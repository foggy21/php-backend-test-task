<?php

namespace App\DataFixtures;

use App\Entity\Machine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MachineFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $machines = 
        [
            (new Machine())->setName("WVista")->setProcessors(2)->setMemory(1024)->setAvailableProcessors(2)->setAvailableMemory(1024),
            (new Machine())->setName("W10")->setProcessors(3)->setMemory(4096)->setAvailableProcessors(3)->setAvailableMemory(4096),
            (new Machine())->setName("WXP")->setProcessors(2)->setMemory(2048)->setAvailableProcessors(2)->setAvailableMemory(2048),
            (new Machine())->setName("W8")->setProcessors(1)->setMemory(2048)->setAvailableProcessors(1)->setAvailableMemory(2048),
            (new Machine())->setName("W7")->setProcessors(1)->setMemory(1024)->setAvailableProcessors(1)->setAvailableMemory(1024),
            (new Machine())->setName("Mac")->setProcessors(4)->setMemory(512)->setAvailableProcessors(4)->setAvailableMemory(512),
        ];
        $manager->persist($machines[0]);
        $manager->persist($machines[1]);
        $manager->persist($machines[2]);
        $manager->persist($machines[3]);
        $manager->persist($machines[4]);
        $manager->persist($machines[5]);
        $manager->flush();
    }
}
