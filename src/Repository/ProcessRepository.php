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

    public function findAllAndSortByAsc()
    {
        $processes = $this->findAll();
        usort($processes, [$this, 'sortByAsc']);
        return $processes;
    }

    public function findAllAndSortByDesc()
    {
        $processes = $this->findAll();
        usort($processes, [$this, 'sortByDesc']);
        return $processes;
    }

    public function sortByAsc(Process $processFirst, Process $processSecond)
    {
        if ($processFirst->getRequiredProcessors() == $processSecond->getRequiredProcessors())
        {
            return $processFirst->getRequiredMemory() <=> $processSecond->getRequiredMemory();
        }
        return $processFirst->getRequiredProcessors() <=> $processSecond->getRequiredProcessors();
    }

    public function sortByDesc(Process $processFirst, Process $processSecond)
    {
        if ($processSecond->getRequiredProcessors() == $processFirst->getRequiredProcessors())
        {
            return $processSecond->getRequiredMemory() <=> $processFirst->getRequiredMemory();
        }
        return $processSecond->getRequiredProcessors() <=> $processFirst->getRequiredProcessors();
    }
}
