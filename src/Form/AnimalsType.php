<?php

namespace App\Form;

use App\Entity\Animals;
use App\Entity\Habitats;
use App\Entity\Images;
use App\Entity\Races;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('state', TextareaType::class, [
                'required' => false,
            ])
            ->add('details', TextareaType::class, [
                'required' => false,
            ])
            ->add('habitat', EntityType::class, [
                'class' => Habitats::class,
                'choice_label' => 'name',
                'required' => false,
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Upload Image',
                'mapped' => false,
                'required' => false,
            ])
            ->add('race', EntityType::class, [
                'class' => Races::class,
                'choice_label' => 'label',
                'required' => false,
            ])
            ->add('clicks', null, [
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
