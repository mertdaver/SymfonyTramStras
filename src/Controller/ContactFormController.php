<?php

// HONEYPOT
namespace App\Controller;

use App\Entity\ContactMessage;
use App\Form\ContactMessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ContactFormController extends AbstractController
{
    #[Route('/contact_form', name: 'contact_form')]
    public function contactForm(Request $request)
    {
        // Création d'une nouvelle instance de ContactMessage.
        $contactMessage = new ContactMessage();
        
        // Création du formulaire associé à l'entité ContactMessage.
        $form = $this->createForm(ContactMessageType::class, $contactMessage);
        
        // Traitement des données soumises si la requête est de type POST.
        $form->handleRequest($request);

        // Vérification du honeypot (champ caché destiné à tromper les bots).
        $honeypot = $request->request->get('honeypot');
        
        // Si le honeypot est rempli (ce qui ne devrait jamais être le cas pour un utilisateur réel),
        // alors on considère la soumission comme étant effectuée par un bot.
        if (!empty($honeypot)) {
            // On redirige simplement vers le formulaire sans traiter les données,
            // ce qui donne l'illusion au bot que sa soumission a réussi.
            return $this->render('contact_form/contact_form.html.twig', [
                'contact_form' => $form->createView(),
            ]);
        }

        // Vérification de la soumission et de la validité du formulaire.
        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrement du message de contact dans la base de données.
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contactMessage);
            $entityManager->flush();

            // Redirection vers la page d'accueil après la soumission réussie du formulaire.
            return $this->redirectToRoute('home');
        }

        // Rendu du formulaire de contact.
        return $this->render('contact_form/contact_form.html.twig', [
            'contact_form' => $form->createView(),
        ]);
    }
}