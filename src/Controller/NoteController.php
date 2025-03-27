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
        // method pour créer une note
        if (!$this->isGranted('ROLE_USER')) return $this->redirectToRoute('app_home');
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
            $this->addFlash('success', 'Note crée avec succès');

            return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('note/add.html.twig', [
            'note' => $note,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'app_note_show', methods: ['GET'])]
    public function show(Note $note): Response
    {
        // method pour afficher une note
        if (!$this->isGranted('ROLE_USER')) return $this->redirectToRoute('app_home');
        // si l'utilisateur n'est pas connecté il est redirigé vers la page d'accueil
        return $this->render('note/show.html.twig', [
            'note' => $note,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_note_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Note $note, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // method pour modifier une note
        if (!$this->isGranted('ROLE_USER')) return $this->redirectToRoute('app_home');

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
            $entityManager->flush();
            $this->addFlash('success', 'Note modifié avec succès');

            return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('note/edit.html.twig', [
            'note' => $note,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_note_delete', methods: ['POST'])]
    public function delete(Request $request, Note $note, EntityManagerInterface $entityManager): Response
    {
        // method pour supprimer une note
        if (!$this->isGranted('ROLE_USER')) return $this->redirectToRoute('app_home');


        if ($this->isCsrfTokenValid('delete' . $note->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($note);
            $entityManager->flush();
            $this->addFlash('success', 'Note supprimé avec succès');
        }

        return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/favori/{id}', name: 'app_note_favori', methods: ['GET'])]
    public function favori(Note $note, EntityManagerInterface $entityManager): Response
    {
        // method pour mettre une note en favori
        if (!$this->isGranted('ROLE_USER')) return $this->redirectToRoute('app_home');
        $note->setIsFavori(!$note->getIsFavori());
        //  si la note est en favori elle est retiré et vice versa
        $entityManager->flush();
        return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
    }
}
