<?php

namespace App\Form;

use App\Entity\Docteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\GreaterThan;
class DocteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class)
        ->add('prenom', TextType::class)
                  
         ->add('specialite', ChoiceType::class, [
                'choices' => [
                    'Généraliste' => 'Généraliste',
                    'Dermatologue' => 'Dermatologue',
                    'Cardiologue' => 'Cardiologue',
                    'Ophtalmologue' => 'Ophtalmologue',
                    'Pédiatre' => 'Pédiatre',
                    'Neurologue' => 'Neurologue', 
                ],
              ])

              ->add('email', EmailType::class)
              ->add('mdp', PasswordType::class)

              ->add('numtel', TelType::class)
              ->add('profileImage', FileType::class, [
                'label' => 'Image de profil',
                'mapped' => false, // ne pas mapper ce champ à une propriété de l'entité User
                'required' => false, // rendre ce champ facultatif
              ])
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Docteur::class,
        ]);
    }
}
