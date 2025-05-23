<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tag')]
final class TagController extends AbstractController
{

    #[Route('/new', name: 'app_tag_add', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, TagRepository $tags): Response
    {
        // method pour créer un tag
        if (!$this->isGranted('ROLE_USER')) return $this->redirectToRoute('app_home');

        $tag = new Tag();
        $tag->setUser($this->getUser());
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tag);
            $entityManager->flush();
            $this->addFlash('success', 'Tag crée avec succès');
            return $this->redirectToRoute('app_tag_add', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tag/add.html.twig', [
            'tag' => $tag,
            'form' => $form,
            'tags' => $tags->findAll(),
        ]);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    #[Route('/edit/{id}', name: 'app_tag_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tag $tag, EntityManagerInterface $entityManager): Response
    {
        // method pour modifier un tag
        if (!$this->isGranted('ROLE_USER')) return $this->redirectToRoute('app_home');
        if ($tag->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
        }
        // si l'utilisateur n'est pas le propriétaire du tag, il est redirigé vers la page du compte

        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Tag modifié avec succès');

            return $this->redirectToRoute('app_tag_add', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tag/edit.html.twig', [
            'tag' => $tag,
            'form' => $form,
        ]);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    #[Route('/{id}', name: 'app_tag_delete', methods: ['POST'])]
    public function delete(Request $request, Tag $tag, EntityManagerInterface $entityManager): Response
    {
        // method pour supprimer un tag
        if (!$this->isGranted('ROLE_USER')) return $this->redirectToRoute('app_home');
        if ($tag->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
        }
        // si l'utilisateur n'est pas le propriétaire du tag, il est redirigé vers la page du compte

        if ($this->isCsrfTokenValid('delete' . $tag->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tag);
            $entityManager->flush();
            $this->addFlash('success', 'Tag supprimé avec succès');
        }

        return $this->redirectToRoute('app_tag_add', [], Response::HTTP_SEE_OTHER);
    }

    // #[Route('/{id}', name: 'app_tag_show', methods: ['GET'])]
    // public function show(Tag $tag): Response
    // {
    //     return $this->render('tag/show.html.twig', [
    //         'tag' => $tag,
    //     ]);
    // }
}
