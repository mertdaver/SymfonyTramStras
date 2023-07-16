<?php

namespace App\Controller;

use App\Entity\Alerte;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AlerteController extends AbstractController
{
    #[Route('/alerte', name: 'get_alerte', methods: ["GET"])]
    public function getAlerte(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findAll();

        return $this->render('alerte/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/alerte', name: 'alerte', methods: ["POST"])]
    public function sendAlerte(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $data = $request->request->all();
        $user = $security->getUser();

        $pseudo = null;
        if ($user !== null) {
            $pseudo = $user->getPseudo();
        }

        $ligne = $data['ligne'] ?? null;
        $sens = $data['sens'] ?? null;

        // Création d'une nouvelle alerte
        $alerte = new Alerte();
        $alerte->setLigne($ligne);
        $alerte->setSens($sens);
        $alerte->setUser($pseudo);
        $alerte->setAlerteDate(new \DateTime());

        // Enregistrement de l'alerte dans la base de données
        $entityManager->persist($alerte);
        $entityManager->flush();

        return $this->redirectToRoute('confirmation');
    }

    #[Route('/confirmation', name: 'confirmation', methods: ["GET"])]
    public function confirmation(): Response
    {
        return $this->render('alerte/confirmation.html.twig');
    }
}
