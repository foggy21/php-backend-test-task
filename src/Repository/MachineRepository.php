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

    public function findAllAndSortProcessorsByAsc(): array
    {
        $machines = $this->findAll();
        usort($machines, [$this, 'sortProcessorsByAsc']);
        return $machines;
    }

    public function findAllAndSortProcessorsByDesc(): array
    {
        $machines = $this->findAll();
        usort($machines, [$this, 'sortProcessorsByDesc']);
        return $machines;
    }

    public function findAllAndSortMemoryByAsc(): array
    {
        $machines = $this->findAll();
        usort($machines, [$this, 'sortMemoryByAsc']);
        return $machines;
    }

    public function findAllAndSortMemoryByDesc(): array
    {
        $machines = $this->findAll();
        usort($machines, [$this, 'sortMemoryByDesc']);
        return $machines;
    }

    public function updateMemoryAndProcessorsToAvailable(): bool 
    {
        return $this->updateMemoryToAvailable() && $this->updateProcessorsToAvailable();
    }

    private function updateMemoryToAvailable(): bool
    {
        return $this->createQueryBuilder('e')
                    ->update()
                    ->set('e.memory', 'e.available_memory')
                    ->getQuery()
                    ->execute()
        ;
    }

    private function updateProcessorsToAvailable(): bool
    {
        return $this->createQueryBuilder('e')
                    ->update()
                    ->set('e.processors', 'e.available_processors')
                    ->getQuery()
                    ->execute()
        ;
    }

    private function sortProcessorsByAsc(Machine $machineFirst, Machine $machineSecond)
    {
        if ($machineFirst->getProcessors() == $machineSecond->getProcessors())
        {
            return $machineFirst->getMemory() <=> $machineSecond->getMemory();
        }
        return $machineFirst->getProcessors() <=> $machineSecond->getProcessors();
    }

    private function sortProcessorsByDesc(Machine $machineFirst, Machine $machineSecond)
    {
        if ($machineSecond->getProcessors() == $machineFirst->getProcessors())
        {
            return $machineSecond->getMemory() <=> $machineFirst->getMemory();
        }
        return $machineSecond->getProcessors() <=> $machineFirst->getProcessors();
    }

    private function sortMemoryByAsc(Machine $machineFirst, Machine $machineSecond)
    {
        if ($machineFirst->getMemory() == $machineSecond->getMemory())
        {
            return $machineFirst->getProcessors() <=> $machineSecond->getProcessors();
        }
        return $machineFirst->getMemory() <=> $machineSecond->getMemory();
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
