<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;



class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        // Initialisation d'une nouvelle instance d'utilisateur.
        $user = new User();

        // Création du formulaire d'inscription basé sur le type RegistrationFormType.
        $form = $this->createForm(RegistrationFormType::class, $user);

        // Traitement de la requête et mise à jour de l'objet $form.
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide...
        if ($form->isSubmitted() && $form->isValid()) {
            // Hashage du mot de passe saisi en clair par l'utilisateur.
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // Persistance de l'utilisateur en base de données.
            $entityManager->persist($user);
            $entityManager->flush();

            // Génération d'une URL signée et envoi par e-mail à l'utilisateur pour confirmer son inscription.
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('symfonytramstras@proton.me', 'TramStras'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            
            // Authentification automatique de l'utilisateur après son inscription.
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        // Si le formulaire n'est pas soumis ou non valide, affichage du formulaire.
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        // Assure que l'utilisateur est pleinement authentifié.
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    
        // Tente de valider le lien de confirmation d'email.
        // Si le lien est valide, cela définit User::isVerified à vrai et persiste les données.
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            // En cas d'erreur lors de la vérification du courrier électronique, une exception est levée.
            // Cette exception est attrapée ici pour afficher un message d'erreur adapté à l'utilisateur.
            
            // Ajoute un message flash avec l'erreur de vérification de l'email, en utilisant le traducteur pour 
            // obtenir un message d'erreur localisé basé sur la raison fournie par l'exception.
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));
    
            // Redirige l'utilisateur vers la page d'inscription après l'erreur.
            return $this->redirectToRoute('app_register');
        }
    
        // Ajout d'un message flash pour informer l'utilisateur que la vérification a été réussie.
        // NOTE : Il est recommandé de changer la redirection après une vérification réussie 
        // ou de gérer/supprimer ce message flash dans vos templates.
        $this->addFlash('success', 'Votre email est maintenant vérifié.');
    
        // Redirige l'utilisateur vers la page d'inscription après la vérification réussie.
        return $this->redirectToRoute('app_register');
    }
}
