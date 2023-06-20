<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MapController extends AbstractController
{
    #[Route('/map', name: 'app_map')]
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
}
