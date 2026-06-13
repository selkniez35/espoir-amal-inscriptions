<?php

namespace App\Form;

use App\Enum\EmergencyContactTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class EmergencyContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('phone', TextType::class)
            ->add('email', TextType::class, ['required' => false])
            ->add('type', EnumType::class, [
                    'class' => EmergencyContactTypeEnum::class,
                    'choice_label' => fn ($choice) => $choice->label(),
                    'disabled' => true,
                ]);
    }
}
