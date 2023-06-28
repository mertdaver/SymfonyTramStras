<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MapController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    #[Route('/map', name: 'points_map')]
    public function index(): Response
    {
        $url = 'https://api.cts-strasbourg.eu/v1/siri/2.0/stoppoints-discovery';
        $username = 'f7e899aa-b4b3-4e27-bdb3-48ff97432546';
        $password = 'Mry78(5kmM_d';

        $options = [
            'http' => [
                'header' => "Authorization: Basic " . base64_encode($username . ':' . $password) . "\r\n",
                'ignore_errors' => true
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response !== false) {
            $data = json_decode($response, true);

            if (isset($data['StopPointsDelivery']['AnnotatedStopPointRef'])) {
                $stopPoints = $data['StopPointsDelivery']['AnnotatedStopPointRef'];

                $markers = [];
                $lines = [];
                $polylines = [];
                $lineColors = [
                    'A' => '#ff0000', 
                    'B' => '#00ddff', 
                    'C' => '#ffcc00',
                    'D' => '#15b700',
                    'E' => '#000cff',
                    'F' => '#19ff00',
                ];

                foreach ($stopPoints as $stopPoint) {
                    $latitude = $stopPoint['Location']['Latitude'];
                    $longitude = $stopPoint['Location']['Longitude'];
                    $coordinates[] = [$latitude, $longitude];
                    $stopName = $stopPoint['StopName'];
                    $linesDestinations = $stopPoint['LinesDestinations'] ?? [];

                    // Récupérer les destinations des lignes
                    $destinations = [];
                    foreach ($linesDestinations as $lineDestination) {
                        $destination = $lineDestination['DestinationName'];
                        $destinations[] = $destination;
                    }

                    // Créer un marqueur pour chaque point
                    $markers[] = [
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'stopName' => $stopName,
                        'stopCode' => $stopPoint['Extension']['StopCode'],
                        'linesDestinations' => $destinations,
                    ];

                    // Récupérer les lignes de tram
                    $lineName = $stopPoint['Lines'] ?? '';
                    $lineName = str_replace('Ligne ', '', $lineName); // Supprimer le préfixe "Ligne "

                    if (!isset($lines[$lineName])) {
                        $lines[$lineName] = [];
                    }

                    $lines[$lineName][] = [$latitude, $longitude];
                }

                // Créer les objets de polylinéaire pour chaque ligne
                foreach ($lines as $lineName => $lineCoordinates) {
                    $polyline = [
                        'lineName' => $lineName,
                        'coordinates' => $lineCoordinates,
                        'color' => $lineColors[$lineName] ?? '#000000', // Couleur par défaut si la correspondance n'est pas trouvée
                    ];

                    $polylines[] = $polyline;
                }

                return $this->render('map/index.html.twig', [
                    'markers' => $markers,
                    'lines' => $lines,
                    'polylines' => $polylines,
                ]);
            } else {
                var_dump($response);

                return new Response('Failed to retrieve data from the API', 500);
            }
        } else {
            return new Response('Failed to retrieve data from the API', 500);
        }
    }




    #[Route('/horaires/{stopCode}', name: 'horaires_map')]
    public function horaires_map(string $stopCode): Response
    {
        $url = 'https://api.cts-strasbourg.eu/v1/siri/2.0/estimated-timetable?StopPointRef=' . $stopCode;
        $requestorRef = 'f7e899aa-b4b3-4e27-bdb3-48ff97432546';
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

        $username = 'f7e899aa-b4b3-4e27-bdb3-48ff97432546';
        $password = 'Mry78(5kmM_d';

        $client = HttpClient::create([
            'auth_basic' => [$username, $password],
        ]);

        $response = $client->request('GET', $url);
        $data = $response->toArray();

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

                    $stopTimes = [];
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


                    return $this->render('map/horaires.html.twig', [
                        'stopTimes' => $stopTimes,
                        'stopCode' => $stopCode,
                    ]);
                }
            }
        }
    }
}