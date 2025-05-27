<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class MailTestController extends AbstractController
{
    #[Route('/mail/test', name: 'app_mail_test')]
    public function index(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('ogawin.oro@gmail.com')
            ->to('ogawin.oro@gmail.com') // Remplace par l'adresse où tu veux recevoir le mail
            ->subject('Test d’envoi de mail Symfony')
            ->text('Ceci est un test d’email envoyé depuis Symfony.')
            ->html('<p>Ceci est un <strong>test</strong> d’email envoyé depuis Symfony.</p>');

        $mailer->send($email);

        return new Response('Email envoyé avec succès !');
    }
}
