<?php

namespace App\Controller;

use Exception;
use App\Entity\Marker;
use App\Entity\Alerte;
use Psr\Log\LoggerInterface;
use App\Repository\AlerteRepository;
use App\Repository\MarkerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;


class MapController extends AbstractController
{
    private $logger;
    private $usernameCTS;
    private $passwordCTS;

    public function __construct(LoggerInterface $logger, string $usernameCTS, string $passwordCTS)
    {
        $this->logger = $logger;
        $this->usernameCTS = $usernameCTS;
        $this->passwordCTS = $passwordCTS;   
    }

    #[Route('/map', name: 'points_map')]
    public function index(MarkerRepository $markerRepository, AlerteRepository $alerteRepo): Response
    {
        $latestAlert = $alerteRepo->findOneBy([], ['id' => 'DESC']);

        // URL de l'API CTS pour récupérer les points d'arrêt
        $url = 'https://api.cts-strasbourg.eu/v1/siri/2.0/stoppoints-discovery';
        $usernameCTS = $this->usernameCTS;
        $passwordCTS = $this->passwordCTS;

        // Options pour la requête HTTP
        $options = [
            'http' => [
                'header' => "Authorization: Basic " . base64_encode($usernameCTS . ':' .$passwordCTS) . "\r\n",
                'ignore_errors' => true
            ]
        ];

        // Création du contexte pour la requête HTTP
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response !== false) {
            $data = json_decode($response, true);

            if (isset($data['StopPointsDelivery']['AnnotatedStopPointRef'])) {
                $apiStopPoints = $data['StopPointsDelivery']['AnnotatedStopPointRef'];

                $markers = [];
                $lines = [];
                $polylines = [];

                // Parcourir les points d'arrêt de l'API
                foreach ($apiStopPoints as $apiStopPoint) {
                    $latitude = $apiStopPoint['Location']['Latitude'];
                    $longitude = $apiStopPoint['Location']['Longitude'];
                    $coordinates[] = [$latitude, $longitude];
                    $stopName = $apiStopPoint['StopName'];
                    $linesDestinations = $apiStopPoint['LinesDestinations'] ?? [];

                    // Récupérer les destinations des lignes
                    $destinations = [];
                    foreach ($linesDestinations as $lineDestination) {
                        $destination = $lineDestination['DestinationName'];
                        $destinations[] = $destination;
                    }

                    // Créer un marqueur pour chaque point d'arrêt de l'API
                    $markers[] = [
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'stopName' => $stopName,
                        'stopCode' => $apiStopPoint['Extension']['StopCode'],
                        'linesDestinations' => $destinations,
                        'isCustom' => false, // Marqueur de l'API, icône par défaut utilisée
                    ];

                    // Récupérer les lignes de tram
                    $lineName = $apiStopPoint['Lines'] ?? '';
                    $lineName = str_replace('Ligne ', '', $lineName); // Supprimer le préfixe "Ligne "

                    if (!isset($lines[$lineName])) {
                        $lines[$lineName] = [];
                    }

                    $lines[$lineName][] = [$latitude, $longitude];
                }

                // Récupérer les points ajoutés par les utilisateurs depuis la base de données
                $userMarkers = $markerRepository->findAll();

                // Convertir les marqueurs personnalisés en format compatible
                foreach ($userMarkers as $userMarker) {
                    $markers[] = [
                        'latitude' => $userMarker->getLatitude(),
                        'longitude' => $userMarker->getLongitude(),
                        'stopName' => '', // le nom personnalisé si nécessaire
                        'stopCode' => '', // le code d'arrêt personnalisé si nécessaire
                        'linesDestinations' => [], // les destinations de lignes personnalisées si nécessaire
                        'isCustom' => true, // icône spécifique
                        'text' => $userMarker->getText(),  // le texte associé au marqueur personnalisé
                    ];
                }

                // Créer les objets de polylinéaire pour chaque ligne
                foreach ($lines as $lineName => $lineCoordinates) {
                    $polyline = [
                        'lineName' => $lineName,
                        'coordinates' => $lineCoordinates,
                    ];

                    $polylines[] = $polyline;
                }

                return $this->render('map/index.html.twig', [
                    'markers' => $markers,
                    'lines' => $lines,
                    'polylines' => $polylines,
                    'latestAlert' => $latestAlert
                ]);
            } else {
                var_dump($response);

                return new Response('Échec de récupération des données depuis l\'API', 500);
            }
        } else {
            return new Response('Échec de récupération des données depuis l\'API', 500);
        }
    }


    
    #[Route('/horaires/{stopCode}', name: 'horaires_map')]
    public function horaires_map(string $stopCode): Response
    {
        try {
            // URL de l'API CTS pour récupérer les horaires d'un point d'arrêt spécifique
            $url = 'https://api.cts-strasbourg.eu/v1/siri/2.0/estimated-timetable?StopPointRef=' . $stopCode;
            $requestorRef =  $this->getParameter('usernameCTS');
            $previewInterval = 'PT2H';
            $includeGeneralMessage = 'true';
            $includeFLUO67 = 'false';
            $removeCheckOut = 'false';
            $getStopIdInsteadOfStopCode = 'false';
    
            $queryParameters = [
                'RequestorRef' => $requestorRef,
                'PreviewInterval' => $previewInterval,
                'IncludeGeneralMessage' => $includeGeneralMessage,
                'IncludeFLUO67' => $includeFLUO67,
                'RemoveCheckOut' => $removeCheckOut,
                'GetStopIdInstedOfStopCode' => $getStopIdInsteadOfStopCode,
            ];
    
            $url .= '&' . http_build_query($queryParameters);
    
            $username =  $this->getParameter('usernameCTS');
            $password =  $this->getParameter('passwordCTS');
    
            $client = HttpClient::create([
                'auth_basic' => [$username, $password],
            ]);
    
            $response = $client->request('GET', $url);
            $data = $response->toArray();
    
            $stopTimes = [];

            if (isset($data['ServiceDelivery']['EstimatedTimetableDelivery'])) {
                $timetableDelivery = $data['ServiceDelivery']['EstimatedTimetableDelivery'];
    
                foreach ($timetableDelivery as $versionFrame) {
                    if (isset($versionFrame['EstimatedJourneyVersionFrame'])) {
                        $journeyFrames = $versionFrame['EstimatedJourneyVersionFrame'];
    
                        $estimatedJourneys = [];
                        foreach ($journeyFrames as $journeyFrame) {
                            if (isset($journeyFrame['EstimatedVehicleJourney'])) {
                                $estimatedJourneys = array_merge($estimatedJourneys, $journeyFrame['EstimatedVehicleJourney']);
                            }
                        }
    
                        foreach ($estimatedJourneys as $estimatedJourney) {
                            if (isset($estimatedJourney['EstimatedCalls'])) {
                                $estimatedCalls = $estimatedJourney['EstimatedCalls'];
    
                                foreach ($estimatedCalls as $estimatedCall) {
                                    if ($estimatedCall['StopPointRef'] == $stopCode) {
                                        $stopPointName = $estimatedCall['StopPointName'];
                                        $expectedDepartureTime = new \DateTime($estimatedCall['ExpectedDepartureTime']);
                                        $destinationName = $estimatedCall['DestinationName'];
    
                                        // Ajoute l'heure d'arrêt au tableau uniquement si elle se situe dans le futur
                                        if ($expectedDepartureTime > new \DateTime()) {
                                            $stopTimes[] = [
                                                'stopPointName' => $stopPointName,
                                                'expectedDepartureTime' => $expectedDepartureTime->format('H:i:s'),
                                                'destinationName' => $destinationName,
                                            ];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
    
            // Instead of rendering a twig template, return the data as a JSON response
            return $this->json([
                'stopTimes' => $stopTimes,
                'stopCode' => $stopCode,
            ]);
    
        } catch (\Exception $e) {
            // In case of any exceptions, return an error message as JSON
            return $this->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }


    #[Route("/post/create", name: "post_create", methods: ["POST"])]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $latitude = floatval($request->request->get('lat'));
        $longitude = floatval($request->request->get('lng'));
        $text = $request->request->get('text');

        // Création d'un nouveau marqueur
        $marker = new Marker();
        $marker->setLatitude($latitude);
        $marker->setLongitude($longitude);
        $marker->setText($text);
        $marker->setUser($this->getUser());
        $marker->setCreationDate(new \DateTime()); // Ajout de la date de création

        // Enregistrement du marqueur dans la base de données
        $entityManager->persist($marker);
        $entityManager->flush();

        // Retourne les données au format JSON
        $data = [
            'id' => $marker->getId(),
            'user_id' => $marker->getUser()->getId(),  // Assurez-vous que la méthode getId() existe dans l'entité User
            'latitude' => $marker->getLatitude(),
            'longitude' => $marker->getLongitude(),
            'text' => $marker->getText(),
            'creation_date' => $marker->getCreationDate(),
        ];

        return new Response(json_encode($data));
}

}