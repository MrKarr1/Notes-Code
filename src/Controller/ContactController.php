<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTimeImmutable;
use DateTimeZone;

#[Route('/contact')]
final class ContactController extends AbstractController
{

    #[Route('/message', name: 'app_contact', methods: ['GET', 'POST'])]
    public function new_message_user(Request $request, EntityManagerInterface $entityManager, ContactRepository $contact): Response
    {
        //method pour envoyer un message si l'utilisateur est connecté
        if (!$this->isGranted('ROLE_USER')) return $this->redirectToRoute('app_home');
        $users = $this->getUser();
        $contact = new Contact();
        $contact->setUser($this->getUser());
        $user = $this->getUser();
        if ($user instanceof \App\Entity\User) {
            // si l'utilisateur est connecté, on récupère son email et son id
            // instanceof est un opérateur en PHP qui vérifie si une variable est une instance d'une classe spécifique.
            $contact->setSentBy($user->getId());
            $contact->setEmail($user->getEmail());
        }
        $contact->setCreatedAt(new DateTimeImmutable('now', new DateTimeZone('Europe/Paris')));
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
            'user' => $users,
        ]);
    }

    #[Route('/messages', name: 'app_contact_no_user', methods: ['GET', 'POST'])]
    public function new_message_no_user(Request $request, EntityManagerInterface $entityManager, ContactRepository $contacts): Response
    {
        //method pour envoyer un message sans être connecté
        $contact = new Contact();
        $contact->setCreatedAt(new DateTimeImmutable('now', new DateTimeZone('Europe/Paris')));
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();
            $this->addFlash('success', 'Message envoyé avec succès');

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
            'contacts' => $contacts->findAll(),
        ]);
    }



    #[Route(name: 'app_contact_show', methods: ['GET'])]
    public function index(ContactRepository $contactRepository): Response
    {
        //method pour afficher les messages reçus si l'utilisateur est admin
        if (!$this->isGranted('ROLE_ADMIN')) return $this->redirectToRoute('app_account');
        // si l'utilisateur n'est pas admin, il est redirigé vers la page du compte

        return $this->render('contact/message.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_contact_delete', methods: ['POST'])]
    public function delete(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    {
        //method pour supprimer un message si l'utilisateur est admin
        if (!$this->isGranted('ROLE_ADMIN')) return $this->redirectToRoute('app_account');
        if ($this->isCsrfTokenValid('delete' . $contact->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($contact);
            $entityManager->flush();
            $this->addFlash('success', 'Message supprimé avec succès');
        }

        return $this->redirectToRoute('app_contact_show', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}/respond', name: 'app_respond', methods: ['GET', 'POST'])]
    public function respond(Request $request, EntityManagerInterface $entityManager, Contact $contact): Response
    {
        // method pour répondre à un message si l'utilisateur est admin
        if (!$this->isGranted('ROLE_ADMIN')) return $this->redirectToRoute('app_account');
    
        // Créez un nouvel objet Contact pour la réponse
        $responseContact = new Contact();
        $responseContact->setUser($contact->getUser());
        $responseContact->setEmail($contact->getEmail());
        $user = $this->getUser();
        if ($user instanceof \App\Entity\User) {
            $responseContact->setSentBy($user->getId());
        }
        $responseContact->setCreatedAt(new DateTimeImmutable('now', new DateTimeZone('Europe/Paris')));
    
        // Créez le formulaire pour la réponse
        $form = $this->createForm(ContactType::class, $responseContact);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($responseContact);
            $entityManager->flush();
            $this->addFlash('success', 'Message envoyé avec succès');
    
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('contact/respond.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'app_contact_show', methods: ['GET'])]
    // public function show(Contact $contacts): Response
    // {
    //     return $this->render('contact/respond.html.twig', [
    //         'contact' => $contact,
    //     ]);
    // }


    // #[Route('/{id}/edit', name: 'app_contact_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(ContactType::class, $contact);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('contact/edit.html.twig', [
    //         'contact' => $contact,
    //         'form' => $form,
    //     ]);
    // }
}
