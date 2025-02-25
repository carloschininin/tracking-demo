<?php

namespace App\Controller;

use App\Entity\Chofer;
use App\Form\ChoferType;
use App\Repository\ChoferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/chofer')]
final class ChoferController extends AbstractController
{
    #[Route(name: 'app_chofer_index', methods: ['GET'])]
    public function index(ChoferRepository $choferRepository): Response
    {
        return $this->render('chofer/index.html.twig', [
            'chofers' => $choferRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_chofer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $chofer = new Chofer();
        $form = $this->createForm(ChoferType::class, $chofer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($chofer);
            $entityManager->flush();

            return $this->redirectToRoute('app_chofer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chofer/new.html.twig', [
            'chofer' => $chofer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chofer_show', methods: ['GET'])]
    public function show(Chofer $chofer): Response
    {
        return $this->render('chofer/show.html.twig', [
            'chofer' => $chofer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_chofer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chofer $chofer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChoferType::class, $chofer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_chofer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chofer/edit.html.twig', [
            'chofer' => $chofer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chofer_delete', methods: ['POST'])]
    public function delete(Request $request, Chofer $chofer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chofer->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($chofer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_chofer_index', [], Response::HTTP_SEE_OTHER);
    }
}
