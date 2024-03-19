<?php

namespace App\Repository;

use App\Entity\Process;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Process>
 *
 * @method Process|null find($id, $lockMode = null, $lockVersion = null)
 * @method Process|null findOneBy(array $criteria, array $orderBy = null)
 * @method Process[]    findAll()
 * @method Process[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcessRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Process::class);
    }

    public function findAllAndSortRequiredProcessorsByAsc(): ?array
    {
        $processes = $this->findAll();
        if ($processes)
        {
            usort($processes, [$this, 'sortRequiredProcessorsByAsc']);
            return $processes;
        }
        return null;
    }

    public function findAllAndSortRequiredProcessorsByDesc(): ?array
    {
        $processes = $this->findAll();
        if ($processes)
        {
            usort($processes, [$this, 'sortRequiredProcessorsByDesc']);
            return $processes;
        }
        return null;
    }

    public function findAllAndSortRequiredMemoryByAsc(): ?array
    {
        $processes = $this->findAll();
        if ($processes)
        {
            usort($processes, [$this, 'sortRequiredMemoryByAsc']);
            return $processes;
        }
        return null;
    }

    public function findAllAndSortRequiredMemoryByDesc(): ?array
    {
        $processes = $this->findAll();
        if ($processes)
        {
            usort($processes, [$this, 'sortRequiredMemoryByDesc']);
            return $processes;
        }
        return null;
    }


    public function getNullMachineSortedRequiredProcessorsByAsc() : ?Process
    {
        $processes = $this->findByNullMachine();
        if ($processes)
        {
            usort($processes, [$this, 'sortRequiredProcessorsByAsc']);
            return $processes[0];
        }
        return null;
    }

    public function getNullMachineSortedRequiredMemoryByAsc() : ?Process
    {
        $processes = $this->findByNullMachine();
        if ($processes)
        {
            usort($processes, [$this, 'sortRequiredMemoryByAsc']);
            return $processes[0];
        }
        return null;
    }

    public function updateMachinesToNull() : void
    {
        $this->createQueryBuilder('e')
            ->update()
            ->set('e.machine', 'NULL')
            ->where('e.machine IS NOT NULL')
            ->getQuery()
            ->execute()
        ;
    }

    private function findByNullMachine() : ?array
    {
        $processes = $this->createQueryBuilder('e')
                        ->andWhere('e.machine IS NULL')
                        ->getQuery()
                        ->getResult()
        ;
        return $processes != [] ? $processes : null;
    }

    private function sortRequiredProcessorsByAsc(Process $processFirst, Process $processSecond)
    {
        if ($processFirst->getRequiredProcessors() == $processSecond->getRequiredProcessors())
        {
            return $processFirst->getRequiredMemory() <=> $processSecond->getRequiredMemory();
        }
        return $processFirst->getRequiredProcessors() <=> $processSecond->getRequiredProcessors();
    }

    private function sortRequiredProcessorsByDesc(Process $processFirst, Process $processSecond)
    {
        if ($processSecond->getRequiredProcessors() == $processFirst->getRequiredProcessors())
        {
            return $processSecond->getRequiredMemory() <=> $processFirst->getRequiredMemory();
        }
        return $processSecond->getRequiredProcessors() <=> $processFirst->getRequiredProcessors();
    }

    private function sortRequiredMemoryByAsc(Process $processFirst, Process $processSecond)
    {
        if ($processFirst->getRequiredMemory() == $processSecond->getRequiredMemory())
        {
            return $processFirst->getRequiredProcessors() <=> $processSecond->getRequiredProcessors();
        }
        return $processFirst->getRequiredMemory() <=> $processSecond->getRequiredMemory();
    }

    private function sortRequiredMemoryByDesc(Process $processFirst, Process $processSecond)
    {
        if ($processSecond->getRequiredMemory() == $processFirst->getRequiredMemory())
        {
            return $processSecond->getRequiredProcessors() <=> $processFirst->getRequiredProcessors();
        }
        return $processSecond->getRequiredMemory() <=> $processFirst->getRequiredMemory();
    }
}
