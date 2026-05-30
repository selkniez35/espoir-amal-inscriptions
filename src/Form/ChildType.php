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
                'label' => 'Nom'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Prénom'
            ])

            ->add('birthDate', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text'
            ])
            ->add('level', ChoiceType::class, [
                'choices' => array_combine(range(0, 8), range(0, 8)),
                'label' => 'Niveau'
            ]);
    }
}
