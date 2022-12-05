<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use DateTime;
use Doctrine\ORM\Mapping\PostRemove;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\All;

class CommentController extends AbstractController
{
    private CommentRepository $repo;

    public function __construct(CommentRepository $Crepo)
    {
        $this->Crepo = $Crepo;
    }
    /*   #[IsGranted('ROLE_USER')] */

    #[Route('/create/{postId}', name: 'comment.create')]
    public function create(PostRepository $Prepo, $postId, Request $request): Response
    {

        $post = $Prepo->find($postId);
        $comments = $post->getComments();

        $commentBody = $request->toArray();

        //Pousser dans la base de donnée et on recupere chaque propriété de l'entité//
        $commentaire = new Comment;

        $commentaire->setAutorname($this->getUser()->getUsername()); /*  on utilise la key dans script  body: JSON.stringify */
        $commentaire->setContent($commentBody['contentvalue']);
        $commentaire->setCreatedAt(new DateTime());
        $commentaire->setUser($this->getUser());
        $commentaire->setPost($post);

        $this->Crepo->add($commentaire, true);
  

        //On recuperer chaque element grave au tableau//
        $allcomments = [];
        foreach ($comments as $comment) {

            $allcomments[] = [
                'id' => $comment->getId(),
                'autorname' => $comment->getAutorname(),
                'content' => $comment->getContent(),
                'createdAt' => $comment->getCreatedAt()->format("m/d/Y")
            ];
        }

        return $this->json($allcomments);
    }
}
