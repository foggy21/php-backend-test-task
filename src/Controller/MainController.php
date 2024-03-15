<?php

namespace App\Controller;

use App\Repository\MachineRepository;
use App\Repository\ProcessRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(MachineRepository $machineRepository, ProcessRepository $processRepository): Response
    {
        $machines = $machineRepository->findAll();
        $processes = $processRepository->findAll();
        usort($machines, [$machineRepository, 'sortDesc']);
        usort($processes, [$processRepository, 'sortAsc']);

        return $this->render('main/index.html.twig', [
            'machines' => $machines,
            'processes' => $processes,
        ]);
    }
}
