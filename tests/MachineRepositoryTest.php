<?php

namespace App\Tests;

use App\Repository\MachineRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MachineRepositoryTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testFindAllAndSortProcessorsByDesc(): void 
    {
        $machineRepository = self::getContainer()->get(MachineRepository::class);
        $reflectionSortDesc = new \ReflectionMethod(MachineRepository::class, 'sortProcessorsByDesc');
        $reflectionSortDesc->setAccessible(true);

        $WVista = $machineRepository->findBy(["name" => "WVista"]);
        $W10 = $machineRepository->findBy(["name" => "W10"]);
        $W8 = $machineRepository->findBy(["name" => "W8"]);
        $W7 = $machineRepository->findBy(["name" => "W7"]);
        $differentProcessorsSort =  $reflectionSortDesc->invoke($machineRepository, $WVista[0], $W10[0]);
        $equalProcessorsSort = $reflectionSortDesc->invoke($machineRepository, $W8[0], $W7[0]);

        $this->assertEquals(1, $differentProcessorsSort);
        $this->assertEquals(-1, $equalProcessorsSort);
    }

    public function testFindAllAndSortMemoryByDesc(): void 
    {
        $machineRepository = self::getContainer()->get(MachineRepository::class);
        $reflectionSortDesc = new \ReflectionMethod(MachineRepository::class, 'sortMemoryByDesc');
        $reflectionSortDesc->setAccessible(true);

        $WVista = $machineRepository->findBy(["name" => "WVista"]);
        $W10 = $machineRepository->findBy(["name" => "W10"]);
        $WXP = $machineRepository->findBy(["name" => "WXP"]);
        $W8 = $machineRepository->findBy(["name" => "W8"]);
        
        $differentMemorySort =  $reflectionSortDesc->invoke($machineRepository, $WVista[0], $W10[0]);
        $equalMemorySort = $reflectionSortDesc->invoke($machineRepository, $WXP[0], $W8[0]);

        $this->assertEquals(1, $differentMemorySort);
        $this->assertEquals(-1, $equalMemorySort);
    }

    public function testUpdatePropertiesToAvailable(): void 
    {
        $machineRepository = self::getContainer()->get(MachineRepository::class);
        $entityManager = self::getContainer()->get('doctrine')->getManager();

        $reflectionProcessorsUpdate = new \ReflectionMethod(MachineRepository::class, 'updateProcessorsToAvailable');
        $reflectionProcessorsUpdate->setAccessible(true);
        
        $reflectionMemoryUpdate = new \ReflectionMethod(MachineRepository::class, 'updateMemoryToAvailable');
        $reflectionMemoryUpdate->setAccessible(true);

        $WVista = $machineRepository->findBy(["name" => "WVista"])[0]->setProcessors(0)->setMemory(725);
        $W10 = $machineRepository->findBy(["name" => "W10"])[0]->setProcessors(1)->setMemory(0);
        $WXP = $machineRepository->findBy(["name" => "WXP"])[0]->setProcessors(1)->setMemory(1024);
        
        $reflectionProcessorsUpdate->invoke($machineRepository);
        $reflectionMemoryUpdate->invoke($machineRepository);

        $entityManager->refresh($WVista);
        $entityManager->refresh($W10);
        $entityManager->refresh($WXP);

        $this->assertEquals($WVista->getAvailableMemory(), $WVista->getMemory());
        $this->assertEquals($WVista->getAvailableProcessors(), $WVista->getProcessors());
        $this->assertEquals($W10->getAvailableMemory(), $W10->getMemory());
        $this->assertEquals($W10->getAvailableProcessors(), $W10->getProcessors());
        $this->assertEquals($WXP->getAvailableMemory(), $WXP->getMemory());
        $this->assertEquals($WXP->getAvailableProcessors(), $WXP->getProcessors());
    }
}
