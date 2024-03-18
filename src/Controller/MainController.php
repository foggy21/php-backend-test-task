<?php

namespace App\Controller;

use App\Repository\MachineRepository;
use App\Repository\ProcessRepository;
use App\Entity\Machine;
use App\Entity\Process;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{   
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_main')]
    public function index(MachineRepository $machineRepository, ProcessRepository $processRepository): Response
    {
        $this->updateEntitesToOriginal($machineRepository, $processRepository);

        
        $machines = $machineRepository->findAllAndSortProcessorsByDesc();
        if ($machines) 
        {
            $this->allocateProcessToMachineByProcess($machines, $processRepository);
        }

        $machines = $machineRepository->findAllAndSortMemoryByDesc();
        if ($machines)
        {
            $this->allocateProcessToMachineByMemory($machines, $processRepository);
        }
        
        return $this->render('main/index.html.twig', [
            'machines' => $machineRepository->findAllAndSortProcessorsByDesc(),
            'processes' => $processRepository->findAllAndSortRequiredProcessorsByAsc(),
        ]);
    }

    private function updateEntitesToOriginal(MachineRepository $machineRepository, ProcessRepository $processRepository)
    {
        $processRepository->updateMachineToNull();
        $machineRepository->updateMemoryAndProcessorsToAvailable();
    }

    private function allocateProcessToMachineByProcess(array $machines, ProcessRepository $processRepository)
    {
        foreach($machines as $machine)
        {
            while($this->machineIsSuitableForProcessRequirements($machine, $process = $processRepository->getNullMachineSortedRequiredProcessorsByAsc())) 
            {
                $this->allocateProcessToMachine($process, $machine);
            }
        }
    }

    private function allocateProcessToMachineByMemory(array $machines, ProcessRepository $processRepository)
    {
        foreach($machines as $machine)
        {
            while($this->machineIsSuitableForProcessRequirements($machine, $process = $processRepository->getNullMachineSortedRequiredMemoryByAsc())) 
            {
                $this->allocateProcessToMachine($process, $machine);
            }
        }
    }

    private function allocateProcessToMachine(?Process $process, ?Machine $machine)
    {
        if ($machine && $process)
        {
            $process->setMachine($machine);
            $this->entityManager->flush();
        }
    }

    private function machineIsSuitableForProcessRequirements(?Machine $machine, ?Process $process): bool
    {
        if ($machine && $process)
        {
            if ($process->getRequiredProcessors() <= $machine->getProcessors() &&
            $process->getRequiredMemory() <= $machine->getMemory())
            {
                return true;
            }
        }
        return false;
    }

}
