<?php

namespace App\Controller;

use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\Langage;
use App\Form\LangageType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LangageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/langage')]
#[isGranted('ROLE_ADMIN')]
final class LangageController extends AbstractController
{


    #[Route('/new', name: 'app_langage_add', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, LangageRepository $langages): Response
    {
        $langage = new Langage();
        $form = $this->createForm(LangageType::class, $langage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($langage);
            $entityManager->flush();
            $this->addFlash('success', 'Langage crée avec succès');

            return $this->redirectToRoute('app_langage_add', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('langage/add_show.html.twig', [
            'langage' => $langage,
            'form' => $form,
            'langages' => $langages->findAll(),
        ]);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    #[Route('edit/{id}/', name: 'app_langage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Langage $langage, EntityManagerInterface $entityManager): Response
    {
        // method pour modifier un langage reserver au admin
        $form = $this->createForm(LangageType::class, $langage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Langage modifié avec succès');

            return $this->redirectToRoute('app_langage_add', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('langage/edit.html.twig', [
            'langage' => $langage,
            'form' => $form,
        ]);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    #[Route('/{id}', name: 'app_langage_delete', methods: ['POST'])]
    public function delete(Request $request, Langage $langage, EntityManagerInterface $entityManager): Response
    {
        // method pour supprimer un langage reserver au admin
        if ($this->isCsrfTokenValid('delete' . $langage->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($langage);
            $entityManager->flush();
            $this->addFlash('success', 'Langage supprimé avec succès');
        }

        return $this->redirectToRoute('app_langage_add', [], Response::HTTP_SEE_OTHER);
    }
}
