<?php

namespace App\Form;

use App\Entity\Pedido;
use App\Entity\PedidoDetalle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PedidoDetalleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('descripcion')
            ->add('peso', null, [
                'required' => true,
                'attr' => [
                    'class' => 'peso_input',
                    'placeholder' => '00'
                ]
            ])
            ->add('costo',null, [
                'required' => true,
                'attr' => [
                    'class' => 'costo_input',
                    'placeholder' => '0.00',
                    'readonly' => true
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PedidoDetalle::class,
        ]);
    }
}
