<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    #[Route('/ajax/comments', name: 'comment_add')]
    public function add(Request $request, EntityManagerInterface $em ,
        ArticleRepository $articleRepo, UserRepository $userRepo, 
        CommentRepository $commentRepo
    ): Response
    {
        $commentData = $request->request->all('comment');

        //dd($commentData);

       if(!$this->isCsrfTokenValid('comment-add', $commentData['_token'] )) {
            return $this->json([
                'code' => 'INVALID_CSRF_TOKEN'
            ], Response::HTTP_BAD_REQUEST);
       }

        $article = $articleRepo->findOneBy(['id' => $commentData['article'] ]);

        if(!$article) {
            return $this->json([
                'code' => 'ARTICLE_NOT_FOUND'
            ], Response::HTTP_BAD_REQUEST);
        }

        $comment = new Comment($article);
        $comment->setContent($commentData['content']);
        $comment->setCreatedAt(new \DateTime());
        $comment->setUser($userRepo->findOneBy(['id' => 1] ));

        //dd($comment);
        $em->persist($comment);
        $em->flush();

        $html = $this->renderView('comment/index.html.twig', [
            'comment' => $comment
        ]);

        return $this->json([
            'code' => 'COMMENT_ADDED_SUCCESSFULLY',
            'message' => $html,
            'numberOfComments' => $commentRepo->count(['article' => $article])
        ]);  
    }
}
