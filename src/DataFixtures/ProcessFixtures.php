<?php

namespace App\DataFixtures;

use App\Entity\Process;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProcessFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $processes = 
        [
            (new Process())->setName("CS")->setRequiredProcessors(2)->setRequiredMemory(2555),
            (new Process())->setName("OS")->setRequiredProcessors(1)->setRequiredMemory(128),
            (new Process())->setName("Photoshop")->setRequiredProcessors(4)->setRequiredMemory(3000),
            (new Process())->setName("VSCode")->setRequiredProcessors(1)->setRequiredMemory(1024),
            (new Process())->setName("Steam")->setRequiredProcessors(1)->setRequiredMemory(2100),
            (new Process())->setName("Visual Studio")->setRequiredProcessors(2)->setRequiredMemory(2448),
        ];
        $manager->persist($processes[0]);
        $manager->persist($processes[1]);
        $manager->persist($processes[2]);
        $manager->persist($processes[3]);
        $manager->persist($processes[4]);
        $manager->persist($processes[5]);
        $manager->flush();
    }
}
