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
        dump('Début de la méthode contactForm'); // Vérification du début de la méthode

        // Création d'une nouvelle instance de ContactMessage.
        $contactMessage = new ContactMessage();
        
        // Création du formulaire associé à l'entité ContactMessage.
        $form = $this->createForm(ContactMessageType::class, $contactMessage);
        
        // Traitement des données soumises si la requête est de type POST.
        $form->handleRequest($request);
        dump($request->request->all(), 'Toutes les données soumises'); // Voir toutes les données POST

        // Vérification du honeypot (champ caché destiné à tromper les bots).
        $honeypot = $request->request->get('honeypot');
        
        dump($honeypot, 'Valeur du honeypot'); // Vérifier la valeur du honeypot

        // Si le honeypot est rempli (ce qui ne devrait jamais être le cas pour un utilisateur réel),
        // alors on considère la soumission comme étant effectuée par un bot.
        if (!empty($honeypot)) {
            dump('Soumission détectée comme étant un bot'); // Pour vérifier si la soumission est détectée comme un bot
            return $this->render('contact_form/contact_form.html.twig', [
                'contact_form' => $form->createView(),
            ]);
        }

        // Vérification de la soumission et de la validité du formulaire.
        if ($form->isSubmitted() && $form->isValid()) {
            dump('Formulaire soumis et valide'); // Pour vérifier si le formulaire est bien soumis et valide
            // Enregistrement du message de contact dans la base de données.
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contactMessage);
            $entityManager->flush();

            // Redirection vers la page d'accueil après la soumission réussie du formulaire.
            return $this->redirectToRoute('home');
        } else if ($form->isSubmitted()) {
            dump('Formulaire soumis mais non valide'); // Pour vérifier si le formulaire est soumis mais non valide
            dump($form->getErrors(true, true), 'Erreurs du formulaire'); // Affiche les erreurs de formulaire
        }

        // Rendu du formulaire de contact.
        return $this->render('contact_form/contact_form.html.twig', [
            'contact_form' => $form->createView(),
        ]);
    }
}