<?php

namespace App\Form;

use App\Entity\Consultation;
use App\Entity\Patient; 
use App\Entity\Docteur; 

use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class Consultation1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_consultation')
            ->add('patient', EntityType::class, [
            'class' => Patient::class,
            'choice_label' => 'nom', 
            'multiple' => false,
            'expanded' => false, ] )
            ->add('Docteur', EntityType::class, [
                'class' => Docteur::class,
                'choice_label' => 'nom', 
                'multiple' => false,
                'expanded' => false, ] )
            ->add('dossiermedical')
            ->add('email')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consultation::class,
        ]);
    }
}
