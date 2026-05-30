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
                'choice_label' => 'fullName',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('c')
                        ->where('c.user = :user')
                        ->setParameter('user', $user);
                },
                'label' => 'Enfants déjà enregistrés'
            ])
            ->add('newChildren', CollectionType::class, [
                'entry_type' => ChildType::class,
                'allow_add' => true,
                'by_reference' => false,
                'mapped' => false,
                'label' => 'Ajouter de nouveaux enfants'
            ])
            ->add('notes', null, [
                'label' => 'Notes / Informations complémentaires',
                'attr' => ['rows' => 3]
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
