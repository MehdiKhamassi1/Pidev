<?php

namespace App\Form;
use App\Entity\User;
use App\Entity\Rendezvouz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Rendezvouz1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('daterdv')
            //->add('Patient')
            ->add('User', EntityType::class, [
                'class' => User::class, 
                'choice_label' => 'nom', 
            ])
            ->add('email')
            ->add('local', null, [
                'placeholder' => 'Choisissez un local',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rendezvouz::class,
        ]);
    }
}
