<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SeminarRequestController extends AbstractController
{
    #[Route('/seminar/request', name: 'app_seminar_request')]
    public function index(): Response
    {
        return $this->render('seminar_request/index.html.twig', [
            'controller_name' => 'SeminarRequestController',
        ]);
    }
}
