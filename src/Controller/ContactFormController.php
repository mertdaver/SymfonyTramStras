<?php

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
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contactMessage);
        $form->handleRequest($request);

        // Check for honeypot
        $honeypot = $request->request->get('honeypot');
        if (!empty($honeypot)) {
            // If honeypot is filled, simply render the form again as if nothing happened.
            // Bots won't know they've been caught, but you won't process the data.
            return $this->render('contact_form/contact_form.html.twig', [
                'contact_form' => $form->createView(),
            ]);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contactMessage);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('contact_form/contact_form.html.twig', [
            'contact_form' => $form->createView(),
        ]);
    }
}
