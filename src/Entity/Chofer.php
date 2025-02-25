<?php

namespace App\Entity;

use App\Repository\ChoferRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChoferRepository::class)]
class Chofer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nombre = null;

    #[ORM\Column(length: 8)]
    private ?string $dni = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $licencia = null;

    public function __toString(): string
    {
        return $this->dni. ' - ' . $this->nombre;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): static
    {
        $this->dni = $dni;

        return $this;
    }

    public function getLicencia(): ?string
    {
        return $this->licencia;
    }

    public function setLicencia(?string $licencia): static
    {
        $this->licencia = $licencia;

        return $this;
    }
}
