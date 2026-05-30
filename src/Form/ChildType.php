<?php

namespace App\Form;

use App\Entity\Child;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChildType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('birthday', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'attr' => ['class' => 'mb-2']
            ])
            ->add('level', ChoiceType::class, [
                'label' => 'Niveau',
                'choices' => [
                    'Primaire' => 'Primaire',
                    'Collège' => 'Collège',
                    'Lycée' => 'Lycée',
                ],
                'placeholder' => 'Sélectionnez un niveau',
            ])
            ->add('grade', ChoiceType::class, [
                'label' => 'Classe',
                'choices' => [
                    'Primaire' => [
                        'CP' => 'CP',
                        'CE1' => 'CE1',
                        'CE2' => 'CE2',
                        'CM1' => 'CM1',
                        'CM2' => 'CM2',
                    ],
                    'Collège' => [
                        '6ème' => '6ème',
                        '5ème' => '5ème',
                        '4ème' => '4ème',
                        '3ème' => '3ème',
                    ],
                    'Lycée' => [
                        'Seconde' => 'Seconde',
                        'Première' => 'Première',
                        'Terminale' => 'Terminale',
                    ],
                ],
                'placeholder' => 'Sélectionnez une classe',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Child::class,
        ]);
    }
}
