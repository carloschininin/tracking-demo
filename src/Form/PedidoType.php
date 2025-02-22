<?php

namespace App\Form;

use App\Entity\Cliente;
use App\Entity\Empleado;
use App\Entity\Pedido;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PedidoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fechaRegistro', null, [
                'widget' => 'single_text',
            ])
            ->add('fechaEnvio', null, [
                'widget' => 'single_text',
            ])
            ->add('cliente', EntityType::class, [
                'class' => Cliente::class,
//                'choice_label' => 'dni',
            ])
            ->add('empleado', EntityType::class, [
                'class' => Empleado::class,
//                'choice_label' => 'id',
            ])
            ->add('costoTotal', null, [
                'required' => true,
            ])
            ->add('detalles', CollectionType::class, [
                'entry_type' => PedidoDetalleType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
//                'prototype_name' => '__detallePedido__',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pedido::class,
        ]);
    }
}
