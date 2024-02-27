<?php

namespace App\Form;

use App\Entity\Docteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('nom')
            ->add('prenom')
            ->add('numtel')
            ->add('birth')
            ->add('profile_image')
            ->add('gender')
            ->add('specialite')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Docteur::class,
        ]);
    }
}
