<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MapController extends AbstractController
{
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
                foreach ($stopPoints as $stopPoint) {
                    $latitude = $stopPoint['Location']['Latitude'];
                    $longitude = $stopPoint['Location']['Longitude'];
                    $stopName = $stopPoint['StopName'];

                    // Créer un marqueur pour chaque point
                    $markers[] = [
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'stopName' => $stopName,
                        'stopCode' => $stopPoint['Extension']['StopCode'],
                    ];
                }

                $lines = [];
                if (isset($data['LinesDelivery']['AnnotatedLineRef'])) {
                    $lines = $data['LinesDelivery']['AnnotatedLineRef'];
                }

                return $this->render('map/index.html.twig', [
                    'markers' => $markers,
                    'lines' => $lines,
                ]);
            } else {
                var_dump($response);
                // Gérer le cas d'erreur
                return new Response('Failed to retrieve data from the API', 500);
            }
        } else {
            // Gérer le cas d'erreur
            return new Response('Failed to retrieve data from the API', 500);
        }
    }

    #[Route('/horaires/{stopCode}', name: 'horaires_map')]
    public function horaires_map(string $stopCode): Response
    {
        $url = 'https://api.cts-strasbourg.eu/v1/siri/2.0/estimated-timetable?StopPointRef=' . $stopCode;
        $requestorRef = 'f7e899aa-b4b3-4e27-bdb3-48ff97432546';
        $vehicleMode = 'tram';
        $previewInterval = 'PT30M'; // 30 minutes
        $includeGeneralMessage = 'true'; // ou true si vous souhaitez inclure GeneralMessageDelivery
        $includeFLUO67 = 'false';
        $removeCheckOut = 'false';
        $getStopIdInsteadOfStopCode = 'false';
        
        $queryParameters = [
            'RequestorRef' => $requestorRef,
            'VehicleMode' => $vehicleMode,
            'PreviewInterval' => $previewInterval,
            'IncludeGeneralMessage' => $includeGeneralMessage,
            'IncludeFLUO67' => $includeFLUO67,
            'RemoveCheckOut' => $removeCheckOut,
            'GetStopIdInstedOfStopCode' => $getStopIdInsteadOfStopCode,
        ];

        $url .= '?' . http_build_query($queryParameters);

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
    
            // Process the response data and extract the required information
            if (isset($data['ServiceDelivery']['EstimatedTimetableDelivery']['EstimatedJourneyVersionFrame'])) {
                $journeyFrames = $data['ServiceDelivery']['EstimatedTimetableDelivery']['EstimatedJourneyVersionFrame'];
                
                // Extract the estimated journeys for each journey frame
                $estimatedJourneys = [];
                foreach ($journeyFrames as $journeyFrame) {
                    if (isset($journeyFrame['EstimatedVehicleJourney'])) {
                        $estimatedJourneys = array_merge($estimatedJourneys, $journeyFrame['EstimatedVehicleJourney']);
                    }
                }
                
                // Extract the relevant information from the estimated journeys
                $stopTimes = [];
                foreach ($estimatedJourneys as $estimatedJourney) {
                    if (isset($estimatedJourney['EstimatedCalls']['EstimatedCall'])) {
                        $estimatedCalls = $estimatedJourney['EstimatedCalls']['EstimatedCall'];
                        
                        foreach ($estimatedCalls as $estimatedCall) {
                            $stopPointName = $estimatedCall['StopPointName'];
                            $expectedDepartureTime = $estimatedCall['ExpectedDepartureTime'];
                            
                            // Add the stop time to the array
                            $stopTimes[] = [
                                'stopPointName' => $stopPointName,
                                'expectedDepartureTime' => $expectedDepartureTime,
                            ];
                        }
                    }
                }
                // retourne vers map/horaire et pas vers la carte dans l'index...
                return $this->render('map/horaires.html.twig', [
                    'stopTimes' => $stopTimes,
                    'stopCode' => $stopCode,
                ]);
            } else {
                var_dump($response);
                // Gérer le cas d'erreur
                return new Response('Failed to retrieve data from the API', 500);
            }
        } else {
            // Gérer le cas d'erreur
            return new Response('Failed to retrieve data from the API', 500);
        }
    }
}