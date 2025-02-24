<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use DateTimeImmutable;
use DateTimeZone;

#[Route('/note')]

final class NoteController extends AbstractController

{
    
    #[Route('/new', name: 'app_note_add', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        if(!$this->isGranted('ROLE_USER')) return $this->redirectToRoute('app_home');
        // virifie si l'utilisateur est connecté
        $note = new Note();
        $note->setUser($this->getUser());
        $note->setCreatedAt(new DateTimeImmutable('now', new DateTimeZone('Europe/Paris')));
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('img')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_directory_note'),
                    $newFilename
                );
                $note->setImg($newFilename);
            }
            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('note/add.html.twig', [
            'note' => $note,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_note_show', methods: ['GET'])]
    public function show(Note $note): Response
    {
        if($this->isGranted('ROLE_USER')) return $this->redirectToRoute('app_home');
        return $this->render('note/show.html.twig', [
            'note' => $note,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_note_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Note $note, EntityManagerInterface $entityManager): Response
    {
        if(!$this->isGranted('ROLE_USER')) return $this->redirectToRoute('app_home');

        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_note_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('note/edit.html.twig', [
            'note' => $note,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_note_delete', methods: ['POST'])]
    public function delete(Request $request, Note $note, EntityManagerInterface $entityManager): Response
    {
        if(!$this->isGranted('ROLE_USER')) return $this->redirectToRoute('app_home');


        if ($this->isCsrfTokenValid('delete' . $note->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($note);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
    }
}
