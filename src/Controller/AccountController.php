<?php

namespace App\Controller;

use App\Entity\Plan;
use App\Entity\Post;
use App\Entity\Topic;
use App\Entity\User;
use App\Entity\Subscription;
use App\Repository\UserRepository;
use App\Repository\AlerteRepository; 
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(ManagerRegistry $doctrine, AlerteRepository $alerteRepository): Response 
    {
        $plans = $doctrine->getRepository(Plan::class)->findAll();
        $activeSub = $doctrine->getRepository(Subscription::class)->findActiveSub($this->getUser()->getId());
        $latestAlert = $alerteRepository->findLatestAlert();
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        
        $deleteForm = $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete'))
            ->setMethod('POST')
            ->add('submit', SubmitType::class, ['label' => 'Supprimer mon compte'])
            ->getForm();
    
        return $this->render('account/index.html.twig', [
            'user' => $user,
            'plans' => $plans,
            'activeSub' => $activeSub,
            'latestAlert' => $latestAlert,
            'deleteForm' => $deleteForm->createView(),
        ]);
    }
    

    #[Route('/getPseudo/{id}', name: 'get_user_pseudo', methods: ['GET'])]
    public function getPseudo(User $user = null): JsonResponse
    {
        if (!$user) {
            return $this->json(['error' => 'Utilisateur non trouvé'], 404);
        }
    
        return $this->json(['pseudo' => $user->getPseudo()]);
    }

    #[Route('/mes-posts', name: 'mes_posts')]
    public function mesPosts(ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser(); // Obtenez l'utilisateur actuellement connecté
        // Trouvez tous les posts de cet utilisateur
        $posts = $doctrine->getRepository(Post::class)->findBy(['user' => $user]);
        return $this->render('account/mes_posts.html.twig', ['posts' => $posts]);
    }
    
    #[Route('/mes-topics', name: 'mes_topics')]
    public function mesTopics(ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser(); // Obtenez l'utilisateur actuellement connecté
        // Trouvez tous les topics de cet utilisateur
        $topics = $doctrine->getRepository(Topic::class)->findBy(['user' => $user]);
        return $this->render('account/mes_topics.html.twig', ['topics' => $topics]);
    }
    


    #[Route('/user/delete', name: 'user_delete', methods: ['POST'])]
    public function deleteAccount(Request $request): Response
    {
        $user = $this->getUser();
        
        if (!$user) {
            throw new AccessDeniedException('Vous devez être connecté pour supprimer votre compte.');
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        
        // Anonymisation des posts
        foreach ($user->getPosts() as $post) {
            $post->setUser(null);
            $post->setContent('Ce contenu a été anonymisé');
            $entityManager->persist($post);
        }
        
        // Anonymisation des topics
        foreach ($user->getTopics() as $topic) {
            $topic->setUser(null);
            $topic->setTitle('Topic anonymisé');
            $entityManager->persist($topic);
        }
        
        // Anonymisation des markers
        foreach ($user->getMarkers() as $marker) {
            $marker->setUser(null);
            $marker->setName('Marker anonymisé');
            $entityManager->persist($marker);
        }
        
        // Suppression du compte utilisateur
        $entityManager->remove($user);
        $entityManager->flush();
        
        $this->get('security.token_storage')->setToken(null);
        $request->getSession()->invalidate();
        
        return $this->redirectToRoute('homepage');
    }

    public function profile(): Response
    {
        $deleteForm = $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete'))
            ->setMethod('POST')
            ->add('submit', SubmitType::class, ['label' => 'Supprimer mon compte'])
            ->getForm();

        return $this->render('user/account.html.twig', [
            'deleteForm' => $deleteForm->createView(),
        ]);
    }

    
}
