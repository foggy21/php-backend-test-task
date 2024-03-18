<?php

namespace App\Entity;

use App\Repository\ProcessRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProcessRepository::class)]
class Process
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $required_memory = null;

    #[ORM\Column]
    private ?int $required_processors = null;

    #[ORM\ManyToOne(targetEntity: Machine::class)]
    #[ORM\JoinColumn(name: 'machine_id', referencedColumnName: 'id', onDelete: "SET NULL")]
    private Machine|null $machine = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getRequiredMemory(): ?int
    {
        return $this->required_memory;
    }

    public function setRequiredMemory(int $required_memory): static
    {
        $this->required_memory = $required_memory;

        return $this;
    }

    public function getRequiredProcessors(): ?int
    {
        return $this->required_processors;
    }

    public function setRequiredProcessors(int $required_processors): static
    {
        $this->required_processors = $required_processors;

        return $this;
    }

    public function getMachine(): ?Machine
    {
        return $this->machine;
    }

    public function setMachine(Machine $machine): static
    {
        $machine->setProcessors($machine->getProcessors()-$this->getRequiredProcessors());
        $machine->setMemory($machine->getMemory()-$this->getRequiredMemory());
        $this->machine = $machine;

        return $this;
    }
}
