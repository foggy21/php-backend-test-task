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

    public function sortAsc(Machine $machineFirst, Machine $machineSecond)
    {
        if ($machineFirst->getProcessors() == $machineSecond->getProcessors())
        {
            return $machineFirst->getMemory() <=> $machineSecond->getMemory();
        }
        return $machineFirst->getProcessors() <=> $machineSecond->getProcessors();
    }

    public function sortDesc(Machine $machineFirst, Machine $machineSecond)
    {
        if ($machineSecond->getProcessors() == $machineFirst->getProcessors())
        {
            return $machineSecond->getMemory() <=> $machineFirst->getMemory();
        }
        return $machineSecond->getProcessors() <=> $machineFirst->getProcessors();
    }
}
