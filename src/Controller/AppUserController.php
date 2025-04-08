<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class AppUserController extends AbstractController
{
    public function appUser(): Response
    {
        // méthode pour avoir le compte sur toute les pages
        $user = $this->getUser();
        if (!$user) return $this->redirectToRoute('app_login');
        // si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
        return  ['user' => $user,];
    }
}
