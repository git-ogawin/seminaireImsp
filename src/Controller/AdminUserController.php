<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Role;  // N'oublie pas d'importer Role
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AdminUserController extends AbstractController
{
    #[Route('/admin/users/edit/{id}', name: 'admin_user_edit')]
public function edit(User $user, Request $request, EntityManagerInterface $em): Response
{
    if ($request->isMethod('POST')) {
        $roleNames = $request->request->get('roles', []);

        if (!is_array($roleNames)) {
            $roleNames = [$roleNames];
        }

        // Nettoyage des valeurs
        $roleNames = array_filter($roleNames, fn($r) => !empty($r));

        // Récupération explicite des objets Role
        $roles = [];
        $roleRepo = $em->getRepository(Role::class);
        foreach ($roleNames as $roleName) {
            $role = $roleRepo->findOneBy(['name' => $roleName]);
            if ($role) {
                $roles[] = $role;
            }
        }

        // Mise à jour des rôles
        $user->setRoles($roles);

        // Enregistrement
        $em->flush();

        $this->addFlash('success', 'Rôles mis à jour avec succès');

        return $this->redirectToRoute('admin_users');
    }

    return $this->render('admin/users/edit.html.twig', [
        'user' => $user,
        'availableRoles' => $em->getRepository(Role::class)->findAll(),
    ]);
}

}
