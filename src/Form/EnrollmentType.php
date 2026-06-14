<?php

namespace App\Form;

use App\Entity\Child;
use App\Entity\Enrollment;
use App\Enum\Season;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class EnrollmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('child', EntityType::class, [
                'class' => Child::class,
                'choice_label' => 'fullName',
                'label' => 'Enfant',
                'attr' => ['class' => 'form-select']
            ])
            ->add('season', EnumType::class, [
                'class' => Season::class,
                'label' => 'Année'
            ])
            ->add('notes', TextareaType::class, [
                'required' => false
            ]);
    }
}
