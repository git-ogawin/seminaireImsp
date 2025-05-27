<?php

namespace App\Controller;

use App\Entity\Seminar;
use App\Form\SeminarType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeminaireController extends AbstractController
{
    #[Route('/seminaires', name: 'app_seminar_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $seminaires = $em->getRepository(Seminar::class)->findAllOrderedByDate();

        return $this->render('seminar/index.html.twig', [
            'seminaires' => $seminaires,
        ]);
    }

    #[Route('/seminaire/create', name: 'app_seminar_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $seminar = new Seminar();
        $form = $this->createForm(SeminarType::class, $seminar);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($seminar);
            $em->flush();

            $this->addFlash('success', 'Séminaire créé avec succès.');

            return $this->redirectToRoute('app_seminar_index');
        }

        return $this->render('seminar/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/seminaire/edit/{id}', name: 'app_seminar_edit')]
    public function edit(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $seminar = $em->getRepository(Seminar::class)->find($id);

        if (!$seminar) {
            throw $this->createNotFoundException('Séminaire non trouvé');
        }

        $form = $this->createForm(SeminarType::class, $seminar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Séminaire modifié avec succès.');

            return $this->redirectToRoute('app_seminar_index');
        }

        return $this->render('seminar/edit.html.twig', [
            'form' => $form->createView(),
            'seminar' => $seminar,
        ]);
    }

    #[Route('/seminaire/delete/{id}', name: 'app_seminar_delete', methods: ['POST'])]
    public function delete(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $seminar = $em->getRepository(Seminar::class)->find($id);

        if (!$seminar) {
            throw $this->createNotFoundException('Séminaire non trouvé');
        }

        if ($this->isCsrfTokenValid('delete'.$seminar->getId(), $request->request->get('_token'))) {
            $em->remove($seminar);
            $em->flush();

            $this->addFlash('success', 'Séminaire supprimé avec succès.');
        }

        return $this->redirectToRoute('admin_seminaire_liste');
    }
    #[Route('/seminaire/{id}', name: 'seminaire_show')]
    public function show(Seminar $seminaire): Response
    {
        return $this->render('seminaire/show.html.twig', [
            'seminaire' => $seminaire,
        ]);
    }

}