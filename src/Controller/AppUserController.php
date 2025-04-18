<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class AppUserController extends AbstractController
{
    public function appUser(): Response
    {
        // methode pour recupérer l'utilisateur connecté
        // on verifie si l'utilisateur est bien connecté pour eviter les erreurs
        $user = $this->getUser();
        if (!$user) return $this->redirectToRoute('app_login');
        return  ['user' => $user,];
    }
}
