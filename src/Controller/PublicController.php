<?php

namespace App\Controller;

use App\Entity\Seminar;
use App\Entity\NotificationSubscriber;
use App\Form\NotificationSubscriberType;
use App\Repository\SeminarRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class PublicController extends AbstractController
{
    private SeminarRepository $seminarRepository;

    public function __construct(SeminarRepository $seminarRepository)
    {
        $this->seminarRepository = $seminarRepository;
    }

    #[Route('/programmes', name: 'public_programmes')]
    public function programmes(
        MailerInterface $mailer,
        UserRepository $userRepo
    ): Response {
        $today = new \DateTimeImmutable();
        $dateStart = $today->modify('+7 days')->setTime(0, 0);
        $dateEnd = (clone $dateStart)->setTime(23, 59, 59);

        $qb = $this->seminarRepository->createQueryBuilder('s');
        $qb->where('s.statut = :statut')
           ->andWhere('s.date >= :start')
           ->andWhere('s.date <= :end')
           ->setParameter('statut', 'validé')
           ->setParameter('start', $dateStart)
           ->setParameter('end', $dateEnd)
           ->orderBy('s.date', 'ASC');

        $seminars = $qb->getQuery()->getResult();

        $students = $userRepo->findByRole('ROLE_ETUDIANT'); // à implémenter dans le repo

        if ($seminars && !empty($students)) {
            $emails = array_map(fn($user) => $user->getEmail(), $students);

            $body = $this->renderView('emails/programme_seminaires.html.twig', [
                'seminars' => $seminars,
            ]);

            $email = (new Email())
                ->from('secretariat@monuniversite.com')
                ->to(...$emails)
                ->subject('Programmation des séminaires à venir')
                ->html($body);

            $mailer->send($email);
        }

        return $this->render('public/programme.html.twig', [
            'seminars' => $seminars,
        ]);
    }
    #[Route('/', name: 'home')]
    public function home(Request $request, EntityManagerInterface $em): Response
    {
        $subscriber = new NotificationSubscriber();
        $form = $this->createForm(NotificationSubscriberType::class, $subscriber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $existing = $em->getRepository(NotificationSubscriber::class)->findOneBy(['email' => $subscriber->getEmail()]);
            if (!$existing) {
                $em->persist($subscriber);
                $em->flush();
                $this->addFlash('success', 'Inscription réussie ! Vous recevrez désormais les notifications.');
            } else {
                $this->addFlash('warning', 'Cet email est déjà inscrit.');
            }

            return $this->redirectToRoute('home');
        }

        $seminaires = $em->getRepository(Seminar::class)->findBy(['statut' => 'validé']);

        return $this->render('home/index.html.twig', [
            'seminaires' => $seminaires,
            'form' => $form->createView()
        ]);
    }
    #[Route('/public/seminaire/past', name: 'public_seminaire_past')]
    public function pastSeminars(SeminarRepository $seminarRepo): Response
    {
        // Séminaires avec date inférieure à aujourd'hui
        $pastSeminars = $seminarRepo->createQueryBuilder('s')
            ->where('s.date < :now')
            ->setParameter('now', new \DateTime())
            ->orderBy('s.date', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render('public/seminaire_past.html.twig', [
            'seminars' => $pastSeminars,
        ]);
}

}
