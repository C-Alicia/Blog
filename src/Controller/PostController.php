<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\PostLike;
use App\Form\PostType;
use App\Form\CommentType;
use App\Repository\PostLikeRepository;
use App\Repository\PostRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class PostController extends AbstractController
{
    private PostRepository $repo;

    public function __construct(PostRepository $repo)
    {
        $this->repo = $repo;
    }

    //On recupere les données de la table Post avec findAll//
    #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'post.index', methods: ['GET', 'POST'])]
    public function index(): Response
    {
       $posts = $this->repo->findAll();
        return $this->render('post/index.html.twig', ['post' => $posts]); 
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/post/create', name: 'post.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setCreatedAt(new DateTime());
            $this->repo->add($post, true);
            return $this->redirect('/');
        }

        return $this->render('post/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/post/{id}', name: 'post.show', methods: ['GET'])]
    public function show($id, PostLikeRepository $PLRepo): Response
    {
        $post = $this->repo->find($id);

        $checklike = count($post->getLikes());

         
        return $this->render('post/show.html.twig', ['post' => $post, 'check'=>$checklike]);
    }


    



}
