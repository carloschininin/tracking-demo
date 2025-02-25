<?php

namespace App\Form;

use App\Entity\Cargamento;
use App\Entity\Chofer;
use App\Entity\Ciudad;
use App\Entity\Pedido;
use App\Entity\Vehiculo;
use App\Repository\CargamentoRepository;
use App\Repository\PedidoRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CargamentoType extends AbstractType
{
    public function __construct(private readonly CargamentoRepository $cargamentoRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $cargamentoId = $builder->getData()->getId(); // un valor entero o nulo
        $pedidoIds = $this->obtenerPedidosCargamento($cargamentoId);

        $builder
            ->add('fechaPartida', null, [
                'widget' => 'single_text',
            ])
            ->add('ciudadOrigen', EntityType::class, [
                'class' => Ciudad::class,
            ])
            ->add('ciudadDestino', EntityType::class, [
                'class' => Ciudad::class,
            ])
            ->add('pedidos', EntityType::class, [
                'class' => Pedido::class,
                'multiple' => true,
                'query_builder' => function (PedidoRepository $repository) use ($pedidoIds) {
                    return $repository->disponiblesParaCargamento($pedidoIds);
                }
            ])
            ->add('vehiculo', EntityType::class, [
                'class' => Vehiculo::class,
            ])
            ->add('chofer', EntityType::class, [
                'class' => Chofer::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cargamento::class,
        ]);
    }

    private function obtenerPedidosCargamento(?int $cargamentoId): array
    {
        return $this->cargamentoRepository->idsCargamento($cargamentoId);
    }
}
