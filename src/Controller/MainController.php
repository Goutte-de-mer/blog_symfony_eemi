<?php

// Every class needs to have its namespace. It's App\the_directory
namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{

    #[Route('/')]
    public function homepage(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findLatest();
        //directory (in templates/) that matches your controller name (main/) and a filename that matches the method name
        return $this->render('main/homepage.html.twig', [
            'articles' => $articles
        ]);
    }
}
