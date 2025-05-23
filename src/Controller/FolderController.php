<?php

namespace App\Controller;

use App\Entity\Folder;
use App\Form\FolderType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FolderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTimeImmutable;
use DateTimeZone;

#[Route('/folder')]
final class FolderController extends AbstractController
{

    #[Route('/new', name: 'app_folder_add', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, FolderRepository $folders): Response
    {
        // method pour créer un dossier
        if (!$this->isGranted('ROLE_USER')) return $this->redirectToRoute('app_home');
        $folder = new Folder();
        $folder->setUser($this->getUser());
        $folder->setCreatedAt(new DateTimeImmutable('now', new DateTimeZone('Europe/Paris')));
        $form = $this->createForm(FolderType::class, $folder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($folder);
            $entityManager->flush();
            $this->addFlash('success', 'Dossier crée avec succès');
            return $this->redirectToRoute('app_folder_add', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('folder/add.html.twig', [
            'folder' => $folder,
            'form' => $form,
            'folders' => $folders->findAll(),
        ]);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    #[Route('/{id}', name: 'app_folder_delete', methods: ['POST'])]
    public function delete(Request $request, Folder $folder, EntityManagerInterface $entityManager): Response
    {
        // metode pour supprimer un dossier
        if (!$this->isGranted('ROLE_USER')) return $this->redirectToRoute('app_home');
        if ($folder->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
        }
        // si l'utilisateur n'est pas le propriétaire du dossier, il est redirigé vers la page du compte
        if ($this->isCsrfTokenValid('delete' . $folder->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($folder);
            $entityManager->flush();
            $this->addFlash('success', 'Dossier supprimé avec succès');
        }

        return $this->redirectToRoute('app_folder_add', [], Response::HTTP_SEE_OTHER);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    #[Route('/edit/{id}', name: 'app_folder_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Folder $folder, EntityManagerInterface $entityManager): Response
    {
        // method pour modifier un dossier
        if (!$this->isGranted('ROLE_USER')) return $this->redirectToRoute('app_home');
        if ($folder->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
        }
        // si l'utilisateur n'est pas le propriétaire du dossier, il est redirigé vers la page du compte
        $form = $this->createForm(FolderType::class, $folder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Dossier modifié avec succès');
            return $this->redirectToRoute('app_folder_add', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('folder/edit.html.twig', [
            'folder' => $folder,
            'form' => $form,
        ]);
    }


    // #[Route('/{id}', name: 'app_folder_show', methods: ['GET'])]
    // public function show(Folder $folder): Response
    // {
    //     return $this->render('folder/show.html.twig', [
    //         'folder' => $folder,
    //     ]);
    // }



}
