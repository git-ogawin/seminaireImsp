<?php
// src/Controller/AdminController.php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Seminar;
use App\Form\SeminarEvaluationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function dashboard(EntityManagerInterface $em): Response
    {
        // Récupérer toutes les demandes en attente d'évaluation (ex: statut = 'en attente')
        $demandes = $em->getRepository(Seminar::class)->findBy(['statut' => 'en attente']);

        return $this->render('admin/dashboard.html.twig', [
            'demandes' => $demandes,
        ]);
    }

   #[Route('/admin/seminaire/{id}/evaluer', name: 'admin_evaluer_seminaire')]
public function evaluer(
    int $id,
    EntityManagerInterface $em,
    Request $request
): Response {
    $seminaire = $em->getRepository(Seminar::class)->find($id);

    if (!$seminaire) {
        throw $this->createNotFoundException('Séminaire non trouvé');
    }

    $form = $this->createForm(SeminarEvaluationType::class, $seminaire);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();
        $this->addFlash('success', 'Séminaire évalué avec succès.');
        return $this->redirectToRoute('admin_dashboard');
    }

    return $this->render('admin/seminar/evaluer.html.twig', [
        'form' => $form->createView(),
        'seminaire' => $seminaire,
    ]);
}

#[Route('/admin/reports', name: 'admin_reports')]
public function reports(EntityManagerInterface $em): Response
{
    $seminarRepo = $em->getRepository(Seminar::class);
    $userRepo = $em->getRepository(User::class);

    $totalSeminars = $seminarRepo->count([]);
    $totalUsers = $userRepo->count([]);
    $pendingRequests = $seminarRepo->count(['statut' => 'en attente']);

    return $this->render('admin/reports.html.twig', [
        'totalSeminars' => $totalSeminars,
        'totalUsers' => $totalUsers,
        'pendingRequests' => $pendingRequests,
    ]);
}

#[Route('/admin/users/{id}/edit', name: 'admin_user_edit')]
public function editUser(int $id, Request $request, EntityManagerInterface $em): Response
{
    $user = $em->getRepository(User::class)->find($id);

    if (!$user) {
        throw $this->createNotFoundException('Utilisateur non trouvé');
    }

    if ($request->isMethod('POST')) {
        $roles = $request->request->get('roles', []);
        $user->setRoles($roles);
        $em->flush();

        $this->addFlash('success', 'Rôles mis à jour avec succès.');
        return $this->redirectToRoute('admin_manage_users');
    }

    return $this->render('admin/users/edit.html.twig', [
        'user' => $user,
    ]);
}


#[Route('/admin/seminaires', name: 'admin_manage_seminars')]
public function listSeminars(EntityManagerInterface $em): Response
{
    $seminaires = $em->getRepository(Seminar::class)->findAll();

    return $this->render('admin/seminar/list.html.twig', [
        'seminaires' => $seminaires,
    ]);
}

#[Route('/admin/users', name: 'admin_manage_users')]
public function listUsers(EntityManagerInterface $em): Response
{
    $users = $em->getRepository(User::class)->findAll();

    return $this->render('admin/users/list.html.twig', [
        'users' => $users,
    ]);
}
#[Route('/organisateur/seminars', name: 'organisateur_manage_seminars')]
public function manageSeminars(EntityManagerInterface $em): Response
{
    $user = $this->getUser();
    $seminars = $em->getRepository(Seminar::class)->findBy(['organisateur' => $user]);

    return $this->render('organisateur/seminar/index.html.twig', [
        'seminars' => $seminars,
    ]);
}


}
