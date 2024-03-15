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
}
