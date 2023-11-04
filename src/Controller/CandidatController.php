<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\CandidatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CandidatController extends AbstractController
{
    #[Route('/candidat', name: 'app_candidat_profil')]
    public function profil(): Response
    {
        return $this->render('candidat/profil.html.twig');
    }

    // Méthode pour modifier le profil du candidat
    #[Route('/candidat/{id}/edit', name: 'app_candidat_edit')]
    public function edit(Request $request, User $user = null, EntityManagerInterface $entityManager): Response
    {

        if (!$user) {
            $user = new User();
        }
        // dd($user);

        $form = $this->createForm(CandidatType::class, $user);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_candidat_profil');
        }

        return $this->render('candidat/profil.html.twig', [
            'form' => $form,
            'edit' => $user->getId()
        ]);
    }
}
