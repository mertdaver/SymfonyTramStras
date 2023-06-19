<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MapController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/map', name: 'app_map')]
    public function index(): Response
    {
        $url = 'https://api.cts-strasbourg.eu/v1/siri/2.0/lines-discovery';

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

        // dd($response);

        if ($response !== false) {
            $data = json_decode($response, true);

            if (isset($data['LinesDelivery']['AnnotatedLineRef'])) {
                return $this->render('map/index.html.twig', [
                    'lines' => $data['LinesDelivery']['AnnotatedLineRef'],
                ]);
            } else {
                var_dump($response);
                // Handle the error case
                return new Response('Failed to retrieve data from the API', 500);
            }
        } else {
            // Handle the error case
            return new Response('Failed to retrieve data from the API', 500);
        }
    }
}