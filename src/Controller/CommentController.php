<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article/{id}/comment')]
class CommentController extends AbstractController
{

    #[Route('/new', name: 'app_comment_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Article $article): Response
    {
        $comment = new Comment();
        $comment->setCreatedAt(new \DateTimeImmutable());
        $comment->setUser($this->getUser());

        $comment->setArticle($article);
        $payload = json_decode($request->getContent(), true);
        $commentBody = $payload['comment'];

        $comment->setContent($commentBody);
        $comment->setContent($commentBody);
        $entityManager->persist($comment);
        $article->addComment($comment);
        $entityManager->persist($article);
        $entityManager->flush();

        $output = array();
        $output['msg'] = "OK";

        $output["body"] = $commentBody;
        $output["created"] = $comment->getCreatedAt()->format("d/m/Y H:i:s");
        $output["author"] = $this->getUser()->getUserName();

        return new JsonResponse($output);

    }
}
