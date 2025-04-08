<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Note;
use App\Repository\UserRepository;
use App\Repository\NoteRepository;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
#[isGranted('ROLE_ADMIN')]
final class AdminController extends AbstractController
{
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  #[Route('/user', name: 'app_admin_user', methods: ['GET'])]
  public function adminUser(UserRepository $userRepository, NoteRepository $noteRepository): Response
  {
    // method pour afficher les user
    return $this->render('admin/admin_user.html.twig', [
      'users' => $userRepository->findAll(),
      'notes' => $noteRepository->findAll(),
    ]);
  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
  public function adminUserDelete(Request $request, User $user, EntityManagerInterface $entityManager): Response
  {

    if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->getPayload()->getString('_token'))) {

      $notes = $entityManager->getRepository(Note::class)->findBy(['user' => $user]);
      // Mettre à jour les notes pour supprimer la référence à l'utilisateur
      foreach ($notes as $note) {
        // foreach pour chaque note
        $note->setUser(null);  // On met le user à null
        $entityManager->persist($note);  // Persister la modification de la note
      }

      $entityManager->remove($user);
      $entityManager->flush();
      $this->addFlash('success', 'User supprimé avec succès');
    }

    return $this->redirectToRoute('app_admin_user', [], Response::HTTP_SEE_OTHER);
  }
}
