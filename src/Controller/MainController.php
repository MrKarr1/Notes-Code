<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // method pour afficher la page d'accueil
        if ($this->getUser()) return $this->redirectToRoute('app_account');
        return $this->render('main/home.html.twig');
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    #[Route('mentions', name: 'app_mentions')]
    public function mantions(): Response
    {
        // method pour afficher les mentions légales
        return $this->render('mentions/mentions.html.twig');
    }
}
