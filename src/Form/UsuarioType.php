<?php

namespace App\Form;

use App\Entity\Empleado;
use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class)
            ->add('passwordActual', PasswordType::class, [
                'required' => false,
                'label' => 'Password Actual',
            ])
            ->add('password', PasswordType::class, [
                'required' => false,
                'label' => 'Password Nuevo',
            ])
            ->add('empleado', EntityType::class, [
                'class' => Empleado::class,
                'required' => false,
                'placeholder' => 'Seleccione un Empleado ...',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
