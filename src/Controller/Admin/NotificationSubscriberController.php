<?php

namespace App\Controller\Admin;

use App\Entity\NotificationSubscriber;
use App\Repository\NotificationSubscriberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/subscribers')]
class NotificationSubscriberController extends AbstractController
{
    #[Route('/', name: 'admin_subscribers_index', methods: ['GET'])]
    public function index(NotificationSubscriberRepository $repo): Response
    {
        $subscribers = $repo->findAll();

        return $this->render('admin/subscribers/index.html.twig', [
            'subscribers' => $subscribers,
        ]);
    }

    #[Route('/delete/{id}', name: 'admin_subscribers_delete', methods: ['POST'])]
    public function delete(NotificationSubscriber $subscriber, NotificationSubscriberRepository $repo): Response
    {
        $repo->remove($subscriber);

        $this->addFlash('success', 'Abonné supprimé avec succès.');

        return $this->redirectToRoute('admin_subscribers_index');
    }
}
