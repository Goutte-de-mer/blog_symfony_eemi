<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(TranslatorInterface $translator, AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $translatedError = $error
            ? $translator->trans($error->getMessageKey(), $error->getMessageData(), 'security')
            : null;

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => rtrim($translatedError, '.')
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Symfony gère automatiquement le processus de déconnexion.
        // Cette méthode peut rester vide.
        throw new \LogicException('Cette méthode peut être vide. Symfony intercepte automatiquement cette route.');
    }
}
