<?php

namespace App\Entity;

use App\Repository\CargamentoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CargamentoRepository::class)]
class Cargamento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ciudad $ciudadOrigen = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ciudad $ciudadDestino = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaPartida = null;

    /**
     * @var Collection<int, Pedido>
     */
    #[ORM\ManyToMany(targetEntity: Pedido::class)]
    private Collection $pedidos;

    public function __construct()
    {
        $this->pedidos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCiudadOrigen(): ?Ciudad
    {
        return $this->ciudadOrigen;
    }

    public function setCiudadOrigen(?Ciudad $ciudadOrigen): static
    {
        $this->ciudadOrigen = $ciudadOrigen;

        return $this;
    }

    public function getCiudadDestino(): ?Ciudad
    {
        return $this->ciudadDestino;
    }

    public function setCiudadDestino(?Ciudad $ciudadDestino): static
    {
        $this->ciudadDestino = $ciudadDestino;

        return $this;
    }

    public function getFechaPartida(): ?\DateTimeInterface
    {
        return $this->fechaPartida;
    }

    public function setFechaPartida(\DateTimeInterface $fechaPartida): static
    {
        $this->fechaPartida = $fechaPartida;

        return $this;
    }

    /**
     * @return Collection<int, Pedido>
     */
    public function getPedidos(): Collection
    {
        return $this->pedidos;
    }

    public function addPedido(Pedido $pedido): static
    {
        if (!$this->pedidos->contains($pedido)) {
            $this->pedidos->add($pedido);
        }

        return $this;
    }

    public function removePedido(Pedido $pedido): static
    {
        $this->pedidos->removeElement($pedido);

        return $this;
    }

    public function pesoTotal(): float
    {
        $total = 0;
        foreach ($this->pedidos as $pedido) {
            foreach ($pedido->getDetalles() as $detalle) {
                $total += $detalle->getPeso();
            }
        }

        return $total;
    }
}
