<?php

namespace App\Controller;

use App\Entity\Langage;
use App\Form\LangageType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LangageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/langage')]
final class LangageController extends AbstractController
{


    #[Route('/new', name: 'app_langage_add', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, LangageRepository $langages): Response
    {
        // method pour créer un langage reserver au admin
        if (!$this->isGranted('ROLE_ADMIN')) return $this->redirectToRoute('app_account');

        $langage = new Langage();
        $form = $this->createForm(LangageType::class, $langage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($langage);
            $entityManager->flush();

            return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('langage/add_show.html.twig', [
            'langage' => $langage,
            'form' => $form,
            'langages' => $langages->findAll(),
        ]);
    }


    #[Route('/{id}/edit', name: 'app_langage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Langage $langage, EntityManagerInterface $entityManager): Response
    {
        // method pour modifier un langage reserver au admin
        if (!$this->isGranted('ROLE_ADMIN')) return $this->redirectToRoute('app_account');
        $form = $this->createForm(LangageType::class, $langage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('langage/edit.html.twig', [
            'langage' => $langage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_langage_delete', methods: ['POST'])]
    public function delete(Request $request, Langage $langage, EntityManagerInterface $entityManager): Response
    {
        // method pour supprimer un langage reserver au admin
        if (!$this->isGranted('ROLE_ADMIN')) return $this->redirectToRoute('app_account');
        if ($this->isCsrfTokenValid('delete' . $langage->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($langage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
    }
}
