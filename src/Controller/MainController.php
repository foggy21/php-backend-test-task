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
        return $this->render('main/index.html.twig', [
            'machines' => $machineRepository->findAll(),
            'processes' => $processRepository->findAll(),
        ]);
    }
}
