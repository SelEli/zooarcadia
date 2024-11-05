<?php

namespace App\Form;

use App\Entity\Animals;
use App\Entity\Habitats; 
use App\Entity\Images; 
use App\Entity\Races;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description', TextareaType::class)
            ->add('state')
            ->add('race', EntityType::class, [
                'class' => Races::class,
                'choice_label' => 'label',
                'required' => false,
            ])
            ->add('food', TextareaType::class)
            ->add('food_quantity')
            ->add('visit_date', DateTimeType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('details', TextareaType::class)
            ->add('habitat', EntityType::class, [
                'class' => Habitats::class,
                'choice_label' => 'name',
            ])
            ->add('image', EntityType::class, [
                'class' => Images::class,
                'choice_label' => 'url',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animals::class,
        ]);
    }
}
