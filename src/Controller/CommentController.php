<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Constraints\Length;

class CommentController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/comment', name: 'app_new_comment', methods: ["POST"])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function newComment(Request $request, ArticleRepository $articleRepository): Response
    {

        $content = $request->request->get('content');
        $articleId = $request->request->get('article_id');
        if (!trim($content) || strlen($content) <= 1) {
            $this->addFlash('error', 'Un commentaire ne peux pas être vide.');
            return $this->redirectToRoute('app_article_show', ['id' => $articleId]);
        }

        // Association à l'article
        $article = $articleRepository->find($articleId);
        if (!$article) {
            throw $this->createNotFoundException('Article introuvable.');
        }

        $comment = new Comment();
        $comment->setContent($content);
        $comment->setUser($this->getUser());
        $comment->setCreatedAt(new \DateTimeImmutable());
        $comment->setArticle($article);

        $this->entityManager->persist($comment);
        $this->entityManager->flush();

        $this->addFlash('success', 'Votre commentaire a bien été ajouté !');

        return $this->redirectToRoute('app_article_show', ['id' => $articleId]);
    }

    #[Route('/comment/delete/{id}', name: 'app_comment_delete', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        $comment = $entityManager->getRepository(Comment::class)->find($id);

        // Vérifie si le commentaire existe
        if (!$comment) {
            throw $this->createNotFoundException('Commentaire introuvable.');
        }

        // Vérifie que l'utilisateur est bien l'auteur
        if ($comment->getUser() !== $this->getUser()) {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer ce commentaire.');
            return $this->redirectToRoute('app_article_show', ['id' => $comment->getArticle()->getId()]);
        }

        // Suppression du commentaire
        $this->entityManager->remove($comment);
        $this->entityManager->flush();

        $this->addFlash('success', 'Votre commentaire a été supprimé.');

        // Redirection vers l'article d'origine
        return $this->redirectToRoute('app_article_show', ['id' => $comment->getArticle()->getId()]);
    }
}
