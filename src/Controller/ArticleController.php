<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticleController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAllDesc();
        return $this->render('articles/articles.html.twig', [
            'articles' => $articles,
        ]);
    }
    #[Route('/article/{id}', name: 'app_article_show', requirements: ['id' => '\d+'])]
    public function showArticle(int $id, ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->find($id);
        $comments = $article->getComments();
        return $this->render('articles/article.html.twig', [
            'article' => $article,
            'comments' => $comments,
        ]);
    }
}
