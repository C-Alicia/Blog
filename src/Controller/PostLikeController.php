<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\PostLike;
use App\Entity\User;
use App\Repository\PostLikeRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostLikeController extends AbstractController
{
    #[Route('/like/create/{postid}', name: 'postlike.create')]
    public function createlike(
        $postid,
        PostRepository $PRepo,
        PostLikeRepository $LikeRepo
    ): Response {
        $post = $PRepo->find($postid);

        $like = $LikeRepo->findOneBy([
            'post' => $post,
            'user' => $this->getUser(),
        ]);

        if ($like == null) {
            $like = new PostLike;
            $like->setUser($this->getUser())->setPost($post);

            $LikeRepo->add($like, true);
        } else {
            $LikeRepo->remove($like, true);
        }

        $nblike = count($post->getLikes());

        return $this->json(['nblikes' => $nblike]);
    }
}
