<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\ImagesUsers;
use App\Security\EmailVerifier;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;



class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;
    private $tokenManager;

    public function __construct(EmailVerifier $emailVerifier, csrfTokenManagerInterface $csrfTokenManager)
    {
        $this->emailVerifier = $emailVerifier;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {

            //bloque la double soumition du post
            $this->csrfTokenManager->refreshToken("form_intention");
            
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
    
           // Récupérez le fichier du sous-formulaire
           $imageFile = $form->get('imagesUsers')->get('imageFile')->getData();

           // Si un fichier a été téléchargé
            if ($imageFile) {
                // Récupérer la taille du fichier avant de le déplacer
                $fileSize = $imageFile->getSize();

                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de votre image. Veuillez réessayer.');
                    return $this->redirectToRoute('app_register');
                }

                $imagesUsers = new ImagesUsers();
                $imagesUsers->setImageName($newFilename);
                
                // Utiliser la taille du fichier que nous avons récupérée précédemment
                $imagesUsers->setImageSize($fileSize);
                
                $user->setImagesUsers($imagesUsers); // Associez ImagesUsers à User
            }

            $entityManager->persist($user);
            $entityManager->flush();
    
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('symfonytramstras@proton.me', 'TramStras'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
    
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }
    
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
    
        // Redirige l'utilisateur vers la page de connexion après la vérification réussie.
        return $this->redirectToRoute('app_login');
    }
}
