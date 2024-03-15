<?php

namespace App\Controller;

use App\Entity\Process;
use App\Form\ProcessType;
use App\Repository\ProcessRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/process')]
class ProcessController extends AbstractController
{
    #[Route('/', name: 'app_process_index', methods: ['GET'])]
    public function index(ProcessRepository $processRepository): Response
    {
        return $this->render('process/index.html.twig', [
            'processes' => $processRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_process_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $process = new Process();
        $form = $this->createForm(ProcessType::class, $process);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($process);
            $entityManager->flush();

            return $this->redirectToRoute('app_process_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('process/new.html.twig', [
            'process' => $process,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_process_show', methods: ['GET'])]
    public function show(Process $process): Response
    {
        return $this->render('process/show.html.twig', [
            'process' => $process,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_process_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Process $process, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProcessType::class, $process);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_process_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('process/edit.html.twig', [
            'process' => $process,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_process_delete', methods: ['POST'])]
    public function delete(Request $request, Process $process, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$process->getId(), $request->request->get('_token'))) {
            $entityManager->remove($process);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_process_index', [], Response::HTTP_SEE_OTHER);
    }
}
