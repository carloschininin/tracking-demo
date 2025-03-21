<?php

namespace App\Entity;

use App\Repository\PedidoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PedidoRepository::class)]
class Pedido
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaRegistro = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaEnvio = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cliente $cliente = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Empleado $empleado = null;

    /**
     * @var Collection<int, PedidoDetalle>
     */
    #[ORM\OneToMany(targetEntity: PedidoDetalle::class, mappedBy: 'pedido', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $detalles;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $costoTotal = null;

    #[ORM\Column(length: 13, nullable: true)]
    private ?string $codigo = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ciudad $ciudadOrigen = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ciudad $ciudadDestino = null;

    #[ORM\Column(nullable: true)]
    private ?bool $asignado = null;

    public function __construct()
    {
        $this->fechaRegistro = new \DateTime();
        $this->fechaEnvio = new \DateTime('+1 day');
        $this->detalles = new ArrayCollection();
    }

    public function __toString(): string
    {
        return
            $this->getFechaEnvio()->format('d/m/Y'). ' -> '.
            $this->codigo . ' -> '.
            $this->ciudadOrigen->getNombre() . ' -> ' .
            $this->ciudadDestino->getNombre();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaRegistro(): ?\DateTimeInterface
    {
        return $this->fechaRegistro;
    }

    public function setFechaRegistro(\DateTimeInterface $fechaRegistro): static
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    public function getFechaEnvio(): ?\DateTimeInterface
    {
        return $this->fechaEnvio;
    }

    public function setFechaEnvio(?\DateTimeInterface $fechaEnvio): static
    {
        $this->fechaEnvio = $fechaEnvio;

        return $this;
    }

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): static
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getEmpleado(): ?Empleado
    {
        return $this->empleado;
    }

    public function setEmpleado(?Empleado $empleado): static
    {
        $this->empleado = $empleado;

        return $this;
    }

    /**
     * @return Collection<int, PedidoDetalle>
     */
    public function getDetalles(): Collection
    {
        return $this->detalles;
    }

    public function addDetalle(PedidoDetalle $detalle): static
    {
        if (!$this->detalles->contains($detalle)) {
            $this->detalles->add($detalle);
            $detalle->setPedido($this);
        }

        return $this;
    }

    public function removeDetalle(PedidoDetalle $detalle): static
    {
        if ($this->detalles->removeElement($detalle)) {
            // set the owning side to null (unless already changed)
            if ($detalle->getPedido() === $this) {
                $detalle->setPedido(null);
            }
        }

        return $this;
    }

    public function getCostoTotal(): ?string
    {
        return $this->costoTotal;
    }

    public function setCostoTotal(?string $costoTotal): static
    {
        $this->costoTotal = $costoTotal;

        return $this;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(?string $codigo): static
    {
        $this->codigo = $codigo;

        return $this;
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

    public function isAsignado(): ?bool
    {
        return $this->asignado;
    }

    public function setAsignado(?bool $asignado): static
    {
        $this->asignado = $asignado;

        return $this;
    }
}
