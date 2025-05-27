<?php

// src/Command/SendProgrammeEmailCommand.php
namespace App\Command;

use App\Repository\SeminarRepository;
use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Console\Attribute\AsCommand;
use Twig\Environment;

#[AsCommand(
    name: 'app:send-programme-email',
    description: 'Envoie automatiquement la programmation des séminaires aux étudiants 7 jours avant la présentation'
)]
class SendProgrammeEmailCommand extends Command
{
    private $seminarRepository;
    private $userRepository;
    private $mailer;
    private $twig;

    public function __construct(SeminarRepository $seminarRepository, UserRepository $userRepository, MailerInterface $mailer, Environment $twig)
    {
        parent::__construct();
        $this->seminarRepository = $seminarRepository;
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
     $today = new \DateTimeImmutable();
        $dateStart = $today->modify('+7 days')->setTime(0, 0);       // 7 jours à minuit
        $dateEnd = (clone $dateStart)->setTime(23, 59, 59);          // même jour à 23:59

        $qb = $this->seminarRepository->createQueryBuilder('s');

        $qb->where('s.statut = :statut')
        ->andWhere('s.date >= :start')
        ->andWhere('s.date <= :end')
        ->setParameter('statut', 'validé')
        ->setParameter('start', $dateStart)
        ->setParameter('end', $dateEnd)
        ->orderBy('s.date', 'ASC');

        $seminars = $qb->getQuery()->getResult();

        if (!$seminars) {
            $output->writeln('Aucun séminaire à programmer dans les 7 prochains jours.');
            return Command::SUCCESS;
        }

        // Récupérer les étudiants
        $students = $this->userRepository->findByRole('ROLE_ETUDIANT');

        if (!$students) {
            $output->writeln('Aucun étudiant trouvé pour recevoir le mail.');
            return Command::SUCCESS;
        }

        $emails = array_map(fn($user) => $user->getEmail(), $students);

        $body = $this->twig->render('emails/programme_seminaires.html.twig', [
            'seminars' => $seminars,
        ]);

        $email = (new Email())
            ->from('secretariat@monuniversite.com')
            ->bcc(...$emails)
            ->subject('Programmation des séminaires à venir')
            ->html($body);

        $this->mailer->send($email);

        $output->writeln('Email de programmation envoyé à ' . count($emails) . ' étudiants.');

        return Command::SUCCESS;
    }
}
