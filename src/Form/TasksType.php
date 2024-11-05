<?php

namespace App\Form;

use App\Entity\Tasks;
use App\Entity\Animals;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TasksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('createdAt', DateTimeType::class, [
                'widget' => 'single_text',
                'disabled' => true,
            ])
            ->add('dueDate', DateTimeType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('status')
            ->add('animal', EntityType::class, [
                'class' => Animals::class,
                'choice_label' => 'name',
                'required' => false,
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tasks::class,
        ]);
    }
}
