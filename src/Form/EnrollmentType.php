<?php

namespace App\Form;

use App\Entity\Child;
use App\Enum\EnrollmentStatus;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use App\Entity\Enrollment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnrollmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', EnumType::class, [
                'class' => EnrollmentStatus::class,
                'choice_label' => fn (EnrollmentStatus $choice) => $choice->label(),
            ])
            ->add('notes')
            ->add('child', EntityType::class, [
                'class' => Child::class,
                'label' => 'Elève',
                'choice_label' => 'fullName',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Enrollment::class,
        ]);
    }
}
