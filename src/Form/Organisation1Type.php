<?php

namespace App\Form;

use App\Entity\Organisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class Organisation1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'attr' => [
                    'class' => 'form-control form-control-sm', // Add Bootstrap class for styling
                    'placeholder' => 'Nom', // Set placeholder text
                    // You can add other attributes here
                ]
            ])
            ->add('adresse', null, [
                'attr' => [
                    'class' => 'form-control form-control-sm', // Add Bootstrap class for styling
                    'placeholder' => 'Adresse', // Set placeholder text
                    // You can add other attributes here
                ]
            ])
            ->add('email', null, [
                'attr' => [
                    'class' => 'form-control form-control-sm', // Add Bootstrap class for styling
                    'placeholder' => 'Email', // Set placeholder text
                    // You can add other attributes here
                ]
            ])
            ->add('num_tel', null, [
                'attr' => [
                    'class' => 'form-control form-control-sm', // Add Bootstrap class for styling
                    'placeholder' => 'Numéro de téléphone', // Set placeholder text
                    // You can add other attributes here
                ]
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

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Organisation::class,
        ]);
    }
}
