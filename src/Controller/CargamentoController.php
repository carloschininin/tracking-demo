<?php

namespace App\Controller;

use App\Entity\Cargamento;
use App\Form\CargamentoType;
use App\Repository\CargamentoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cargamento')]
final class CargamentoController extends AbstractController
{
    #[Route(name: 'app_cargamento_index', methods: ['GET'])]
    public function index(CargamentoRepository $cargamentoRepository): Response
    {
        return $this->render('cargamento/index.html.twig', [
            'cargamentos' => $cargamentoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cargamento_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cargamento = new Cargamento();
        $form = $this->createForm(CargamentoType::class, $cargamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($cargamento->getPedidos() as $pedido) {
                $pedido->setAsignado(true);
                $entityManager->persist($pedido);
            }

            $entityManager->persist($cargamento);
            $entityManager->flush();

            return $this->redirectToRoute('app_cargamento_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cargamento/new.html.twig', [
            'cargamento' => $cargamento,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cargamento_show', methods: ['GET'])]
    public function show(Cargamento $cargamento): Response
    {
        return $this->render('cargamento/show.html.twig', [
            'cargamento' => $cargamento,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cargamento_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cargamento $cargamento, EntityManagerInterface $entityManager): Response
    {
        // copia de los pedidos
        $pedidosAnteriores = new ArrayCollection();
        foreach ($cargamento->getPedidos() as $pedido) {
            $pedidosAnteriores->add($pedido);
        }

        $form = $this->createForm(CargamentoType::class, $cargamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Los pedidos que han sido retirados
            foreach ($pedidosAnteriores as $pedidoAnterior) {
                if (false === $cargamento->getPedidos()->contains($pedidoAnterior)) {
                    $pedidoAnterior->setAsignado(false);
                    $entityManager->persist($pedidoAnterior);
                }
            }

            // Los nuevos pedidos seleccionados
            foreach ($cargamento->getPedidos() as $pedido) {
                $pedido->setAsignado(true);
                $entityManager->persist($pedido);
            }

            // Grabar en BD
            $entityManager->flush();

            return $this->redirectToRoute('app_cargamento_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cargamento/edit.html.twig', [
            'cargamento' => $cargamento,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cargamento_delete', methods: ['POST'])]
    public function delete(Request $request, Cargamento $cargamento, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cargamento->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($cargamento);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cargamento_index', [], Response::HTTP_SEE_OTHER);
    }
}
