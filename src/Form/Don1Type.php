<?php

namespace App\Form;

use App\Entity\Don;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class Don1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter your name',
                ],
            ])
            ->add('prenom', null, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter your last name',
                ],
            ])
            ->add('email', null, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter your email',
                ],
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Select Type' => 'Select Type',
                    'Dons Monétaires' => 'Dons Monétaires',
                    'Dons d équipements' => 'Dons d équipements',
    
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('montant', null, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Tapez le montant',
                ],
            ])
            ->add('description', null, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter description',
                ],
            ])
            ->add('photo', FileType::class, [
                'label' => 'Description Image',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/gif',
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image',
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control-file',
                ],
            ])
            ->add('Organisation', null, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Select Organisation',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Don::class,
        ]);
    }
}
