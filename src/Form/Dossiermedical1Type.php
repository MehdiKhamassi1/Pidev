<?php

namespace App\Form;

use App\Entity\Dossiermedical;
use App\Entity\Patient;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 


class Dossiermedical1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('groupesang', ChoiceType::class, [
            'choices' => [
                '------' => '------',
                'A+' => 'A+',
                'A-' => 'A-',
                'B+' => 'B+',
                'B-' => 'B-',
                'AB+' => 'AB+',
                'AB-' => 'AB-',
                'O+' => 'O+',
                'O-' => 'O-',
            ],
        ])
        ->add('patient', EntityType::class, [
            'class' => Patient::class,
            'choice_label' => 'nom', 
            'multiple' => false,
            'expanded' => false, ] )        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dossiermedical::class,
        ]);
    }
}
