<?php

// src/Controller/HomeController.php

namespace App\Controller;

use App\Repository\SeminarRepository;
use App\Form\EmailSubscriptionType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(SeminarRepository $seminarRepo, Request $request, EntityManagerInterface $em): Response
{
    $seminaires = $seminarRepo->findUpcomingValidated();

    $form = $this->createForm(EmailSubscriptionType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();
        // enregistrer l’email dans une entité ou envoyer un email de confirmation
        $this->addFlash('success', 'Vous êtes inscrit aux notifications.');

        return $this->redirectToRoute('app_home');
    }

    return $this->render('home/index.html.twig', [
    'seminaires' => $seminaires,
    'formEmail' => $form->createView(), // garder formEmail et corriger Twig
    ]);

}
}
