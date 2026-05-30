<?php

namespace App\Form;

use App\Entity\Enrollment;
use App\Entity\Child;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Doctrine\ORM\EntityRepository;

class EnrollmentType extends AbstractType
{

    public function __construct(private Security $security)
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();

        $builder
            ->add('children', EntityType::class, [
                'class' => Child::class,
                'choice_label' => fn (Child $c) =>
                    $c->getFullName() . ' (Niveau ' . $c->getLevel() . ')',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'query_builder' => fn ($er) =>
                $er->createQueryBuilder('c')
                    ->where('c.user = :user')
                    ->setParameter('user', $this->security->getUser()),
                'label' => 'Enfants existants',
            ])

            ->add('newChild', ChildType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Ajouter un nouvel enfant',
            ])

            ->add('notes', null, [
                'label' => 'Notes',
                'required' => false,
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
