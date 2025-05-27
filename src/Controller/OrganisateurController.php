<?php
// src/Controller/OrganisateurController.php
namespace App\Controller;

use App\Entity\Seminar;
use App\Form\SeminarType;
use App\Form\SeminarSummaryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrganisateurController extends AbstractController
{
    #[Route('/organisateur/dashboard', name: 'organisateur_dashboard')]
    public function dashboard(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        // Historique des demandes de ce user (acceptées ou rejetées)
        $historique = $em->getRepository(Seminar::class)->findBy(['presenter' => $user]);

        return $this->render('organisateur/dashboard.html.twig', [
            'historique' => $historique,
        ]);
    }

   #[Route('/organisateur/seminaire/demande', name: 'organisateur_seminar_demande')]
public function demande(Request $request, EntityManagerInterface $em): Response
{
    $seminar = new Seminar();
    $seminar->setPresenter($this->getUser());
    $seminar->setStatut('en attente');

    $form = $this->createForm(SeminarType::class, $seminar);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Gestion du fichier joint
        $file = $form->get('file')->getData();
        if ($file) {
            // Génère un nom de fichier unique sécurisé
            $safeFilename = uniqid();
            $newFilename = $safeFilename . '.' . $file->guessExtension();

            // Déplace le fichier dans le dossier /public/uploads/seminaires/
            $file->move(
                $this->getParameter('uploads_directory'), // doit être défini dans services.yaml
                $newFilename
            );

            $seminar->setFile($newFilename);
        }

        $em->persist($seminar);
        $em->flush();

        $this->addFlash('success', 'Demande de séminaire soumise avec succès.');

        return $this->redirectToRoute('organisateur_dashboard');
    }

    return $this->render('organisateur/seminar/demande.html.twig', [
        'form' => $form->createView(),
    ]);
}


    // src/Controller/OrganisateurController.php

#[Route('/organisateur/seminars', name: 'organisateur_manage_seminars')]
public function manageSeminars(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $seminars = $em->getRepository(Seminar::class)->findBy(['presenter' => $user]);

        return $this->render('organisateur/seminar/index.html.twig', [
            'seminars' => $seminars,
        ]);
    }
// src/Controller/OrganisateurController.php
#[Route('/organisateur/seminaire/{id}/ajouter-resume', name: 'organisateur_ajouter_resume')]
public function ajouterResume(Request $request, Seminar $seminar, EntityManagerInterface $em): Response
{
    // Vérifier que l'utilisateur est le présentateur
    if ($seminar->getPresenter() !== $this->getUser()) {
        throw $this->createAccessDeniedException('Accès refusé');
    }

    $form = $this->createForm(SeminarSummaryType::class, $seminar);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();
        $this->addFlash('success', 'Résumé ajouté avec succès.');
        return $this->redirectToRoute('organisateur_manage_seminars');
    }

    return $this->render('organisateur/seminar/summary.html.twig', [
        'form' => $form->createView(),
        'seminar' => $seminar,
    ]);
}


}
