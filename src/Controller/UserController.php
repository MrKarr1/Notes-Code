<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserEdit;
use App\Form\UserEditPassword;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


final class UserController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    // la route de méthode register
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, UserPasswordHasherInterface $passwordHasher): Response
    {
        // méthode pour créer un utilisateur
        if ($this->getUser()) return $this->redirectToRoute('app_account');
        // si l'utilisateur est déjà connecté, on le redirige vers son compte
        $user = new User();
        // on crée un nouvel utilisateur
        $user->setRoles(['ROLE_USER']);
        // on lui donne le rôle USER
        $form = $this->createForm(UserType::class, $user);
        // on crée le formulaire
        $form->handleRequest($request);
        // on gère la requête

        if ($form->isSubmitted() && $form->isValid()) {
            // on vérifie si le formulaire est soumis et valide
            $imageFile = $form->get('avatar')->getData();
            // on récupère le fichier image
            if ($imageFile) {
                // si le fichier image existe
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // on récupère le nom original du fichier
                $safeFilename = $slugger->slug($originalFilename);
                // on rend le nom du fichier sûr en enlevant les caractères spéciaux
                // on remplace les espaces par des tirets
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                // on génère un nouveau nom de fichier unique
                // on ajoute un identifiant unique au nom du fichier
                $imageFile->move(
                    // on déplace le fichier image dans le dossier images
                    // on utilise le paramètre images_directory_user défini dans le fichier services.yaml
                    $this->getParameter('images_directory_user'),
                    $newFilename    
                );
                $user->setAvatar($newFilename);
                // on enregistre le nom du fichier dans la base de données
            }
            $plainPassword = $form->get('plainPassword')->getData();
            // on récupère le mot de passe en clair
            $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));
            // on hash le mot de passe
            // on utilise la méthode hashPassword de l'interface UserPasswordHasherInterface

            $entityManager->persist($user);
            $entityManager->flush();
            // on enregistre l'utilisateur dans la base de données
            $this->addFlash('success', 'Votre compte a bien été créé');
            // on affiche un message de succès

            return $this->redirectToRoute('app_account');
            // on redirige l'utilisateur vers son compte
        }

        return $this->render('user/register.html.twig', [
            'form' => $form,
        ]);
        // on affiche le formulaire d'inscription sur la page register.html.twig
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    #[Route('/account', name: 'app_account')]
    public function account(): Response
    {
        // méthode pour afficher le compte
        $user = $this->getUser();
        // on récupère l'utilisateur connecté
        if (!$user) return $this->redirectToRoute('app_login');
        // si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
        return $this->render('user/account.html.twig', [
            'user' => $user,
        ]);
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    #[Route('/edit/{id}', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // méthode pour modifier un utilisateur
        $user = $this->getUser();
        if (!$this->getUser()) return $this->redirectToRoute('app_home');
        // si l'utilisateur n'est pas connecté, on le redirige vers home
        if ($this->getUser() !== $user) return $this->redirectToRoute('app_home');
        // si l'utilisateur n'est pas le propriétaire du compte, on le redirige vers home

        $form = $this->createForm(UserEdit::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('avatar')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_directory_user'),
                    $newFilename
                );
                $user->setAvatar($newFilename);
            }
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Votre compte a bien été modifié');

            return $this->redirectToRoute('app_account');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    #[Route('/edit/password/{id}', name: 'app_user_edit_password', methods: ['GET', 'POST'])]
    public function password(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        // méthode pour modifier le mots de passe de l' utilisateur


        $user = $this->getUser();
        // on récupère l'utilisateur connecté
        if (!$this->getUser()) return $this->redirectToRoute('app_home');
        // si l'utilisateur n'est pas connecté, on le redirige vers home
        if ($this->getUser() !== $user) return $this->redirectToRoute('app_home');
        // si l'utilisateur n'est pas le propriétaire du compte, on le redirige vers home

        $form = $this->createForm(UserEditPassword::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $plainPassword = $form->get('plainPassword')->getData();
            $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre mots de passe a bien été modifié');
            return $this->redirectToRoute('app_account');
        }

        return $this->render('user/edit_password.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}