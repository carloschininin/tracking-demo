<?php

namespace App\Form;

use App\Entity\Cargamento;
use App\Entity\Ciudad;
use App\Entity\Pedido;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CargamentoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cargamento::class,
        ]);
    }
}
