<?php

namespace App\Form;
use App\Entity\Don;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'type' => [
                    'Dons Monétaires' => 'Dons Monétaires',
                    'Dons de Biens' => 'Dons de Biens',
                    'Dons de Temps' => 'Dons de Temps',
                    'Dons de Services' => 'Dons de Services',
                ],
            ])
            ->add('description')
            ->add('Organisation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Don::class,
        ]);
    }
}
