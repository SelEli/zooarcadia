<?php

namespace App\Form;

use App\Entity\Informations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contactAddress')
            ->add('contactPhone')
            ->add('contactEmail')
            ->add('openingDays')
            ->add('openingHours')
            ->add('adultPrice')
            ->add('childPrice')
            ->add('toddlerPrice')
            ->add('familyPrice')
            ->add('groupPrice')
            ->add('parkingInfo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Informations::class,
        ]);
    }
}
