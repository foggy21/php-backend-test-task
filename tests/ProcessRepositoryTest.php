<?php

namespace App\Tests;

use App\Repository\MachineRepository;
use App\Repository\ProcessRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProcessRepositoryTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }
    
    public function testFindAllAndSortRequiredProcessorsByAsc(): void
    {
        $processRepository = self::getContainer()->get(ProcessRepository::class);
        $reflectionSortAsc = new \ReflectionMethod(ProcessRepository::class, 'sortRequiredProcessorsByAsc');
        $reflectionSortAsc->setAccessible(true);

        $CS = $processRepository->findBy(["name" => "CS"]);
        $OS = $processRepository->findBy(["name" => "OS"]);
        $VSCode = $processRepository->findBy(["name" => "VSCode"]);
        $Steam = $processRepository->findBy(["name" => "Steam"]);
        
        $differentProcessorsSort =  $reflectionSortAsc->invoke($processRepository, $CS[0], $OS[0]);
        $equalProcessorsSort = $reflectionSortAsc->invoke($processRepository, $VSCode[0], $Steam[0]);

        $this->assertEquals(1, $differentProcessorsSort);
        $this->assertEquals(-1, $equalProcessorsSort);
    }

    public function testGetNullMachineSortedRequiredProcessorsByAsc(): void
    {
        $processRepository = self::getContainer()->get(ProcessRepository::class);
        $reflectionFindByNullMachine = new \ReflectionMethod(ProcessRepository::class, 'findByNullMachine');
        $reflectionFindByNullMachine->setAccessible(true);

        $processes = $reflectionFindByNullMachine->invoke($processRepository);

        foreach ($processes as $process)
        {
            $this->assertEquals(null, $process->getMachine());
        }

        $reflectionSortAsc = new \ReflectionMethod(ProcessRepository::class, 'sortRequiredProcessorsByAsc');
        $reflectionSortAsc->setAccessible(true);

        $CS = $processRepository->findBy(["name" => "CS"]);
        $OS = $processRepository->findBy(["name" => "OS"]);
        $VSCode = $processRepository->findBy(["name" => "VSCode"]);
        $Steam = $processRepository->findBy(["name" => "Steam"]);
        
        $differentProcessorsSort =  $reflectionSortAsc->invoke($processRepository, $CS[0], $OS[0]);
        $equalProcessorsSort = $reflectionSortAsc->invoke($processRepository, $VSCode[0], $Steam[0]);

        $this->assertEquals(1, $differentProcessorsSort);
        $this->assertEquals(-1, $equalProcessorsSort);
    }

    public function testGetNullMachineSortedRequiredMemoryByAsc(): void
    {
        $processRepository = self::getContainer()->get(ProcessRepository::class);
        $reflectionFindByNullMachine = new \ReflectionMethod(ProcessRepository::class, 'findByNullMachine');
        $reflectionFindByNullMachine->setAccessible(true);

        $processes = $reflectionFindByNullMachine->invoke($processRepository);

        foreach ($processes as $process)
        {
            $this->assertEquals(null, $process->getMachine());
        }

        $reflectionSortAsc = new \ReflectionMethod(ProcessRepository::class, 'sortRequiredMemoryByAsc');
        $reflectionSortAsc->setAccessible(true);

        $CS = $processRepository->findBy(["name" => "CS"]);
        $OS = $processRepository->findBy(["name" => "OS"]);
        $VSCode = $processRepository->findBy(["name" => "VSCode"]);
        $Steam = $processRepository->findBy(["name" => "Steam"]);
        
        $differentProcessorsSort =  $reflectionSortAsc->invoke($processRepository, $CS[0], $OS[0]);
        $equalProcessorsSort = $reflectionSortAsc->invoke($processRepository, $VSCode[0], $Steam[0]);

        $this->assertEquals(1, $differentProcessorsSort);
        $this->assertEquals(-1, $equalProcessorsSort);
    }

    public function testUpdateMachinesToNull() : void
    {
        $processRepository = self::getContainer()->get(ProcessRepository::class);
        $machineRepository = self::getContainer()->get(MachineRepository::class);
        $entityManager = self::getContainer()->get('doctrine')->getManager();

        $machine = $machineRepository->findBy(["name" => "Mac"])[0];
        $OS = $processRepository->findBy(["name" => "OS"])[0]->setMachine($machine);

        $this->assertEquals($machine, $OS->getMachine());

        $processRepository->updateMachinesToNull();

        $entityManager->refresh($OS);
        $entityManager->refresh($machine);
        $this->assertEquals(null, $OS->getMachine());

    }
}
