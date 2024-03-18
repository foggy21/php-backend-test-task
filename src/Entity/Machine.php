<?php

namespace App\Entity;

use App\Repository\MachineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MachineRepository::class)]
class Machine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $memory = null;

    #[ORM\Column]
    private ?int $processors = null;
    
    #[ORM\Column]
    private ?int $available_memory = null;

    #[ORM\Column]
    private ?int $available_processors = null;

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

    public function getMemory(): ?int
    {
        return $this->memory;
    }

    public function setMemory(int $memory): static
    {
        $this->memory = $memory;

        return $this;
    }

    public function getProcessors(): ?int
    {
        return $this->processors;
    }

    public function setProcessors(int $processors): static
    {
        $this->processors = $processors;

        return $this;
    }

    public function getAvailableMemory(): ?int
    {
        return $this->available_memory;
    }

    public function setAvailableMemory(int $available_memory): static
    {
        $this->available_memory = $available_memory;

        return $this;
    }

    public function getAvailableProcessors(): ?int
    {
        return $this->available_processors;
    }

    public function setAvailableProcessors(int $available_processors): static
    {
        $this->available_processors = $available_processors;

        return $this;
    }
}
