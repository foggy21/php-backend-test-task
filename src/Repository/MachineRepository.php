<?php

namespace App\Repository;

use App\Entity\Machine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Machine>
 *
 * @method Machine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Machine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Machine[]    findAll()
 * @method Machine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MachineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Machine::class);
    }

    public function findAllAndSortProcessorsByDesc(): ?array
    {
        $machines = $this->findAll();
        if ($machines) 
        {
            usort($machines, [$this, 'sortProcessorsByDesc']);
            return $machines;
        }
        return null;
    }

    public function findAllAndSortMemoryByDesc(): ?array
    {
        $machines = $this->findAll();
        if ($machines)
        {
            usort($machines, [$this, 'sortMemoryByDesc']);
            return $machines;
        }
        return null;
    }

    public function updatePropertiesToAvailable(): void 
    {
        $this->updateMemoryToAvailable()
            ->updateProcessorsToAvailable()
        ;
    }

    private function updateMemoryToAvailable(): static
    {
        $this->createQueryBuilder('e')
                    ->update()
                    ->set('e.memory', 'e.available_memory')
                    ->getQuery()
                    ->execute()
        ;
        return $this;
    }

    private function updateProcessorsToAvailable(): static
    {
        $this->createQueryBuilder('e')
                    ->update()
                    ->set('e.processors', 'e.available_processors')
                    ->getQuery()
                    ->execute()
        ;
        return $this;
    }

    private function sortProcessorsByDesc(Machine $machineFirst, Machine $machineSecond)
    {
        if ($machineSecond->getProcessors() == $machineFirst->getProcessors())
        {
            return $machineSecond->getMemory() <=> $machineFirst->getMemory();
        }
        return $machineSecond->getProcessors() <=> $machineFirst->getProcessors();
    }

    private function sortMemoryByDesc(Machine $machineFirst, Machine $machineSecond)
    {
        if ($machineSecond->getMemory() == $machineFirst->getMemory())
        {
            return $machineSecond->getProcessors() <=> $machineFirst->getProcessors();
        }
        return $machineSecond->getMemory() <=> $machineFirst->getMemory();
    }
}
