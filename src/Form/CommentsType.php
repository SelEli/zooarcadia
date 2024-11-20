<?php

namespace App\Form;

use App\Entity\Comments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
<<<<<<< HEAD
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire',
            ]);

        $comment = $options['data'];
        if (($this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_EMPLOYEE')) && !$comment->isVisible()) {
            $builder->add('isVisible', CheckboxType::class, [
                'label' => 'Visible',
                'required' => false,
                'mapped' => true,
            ]);
        }
=======
            ->add('name', TextType::class)
            ->add('comment', TextareaType::class);
            // On n'inclut pas le champ 'isVisible' dans le formulaire de création
>>>>>>> parent of aaf67b6 (Ajout du MongoDB pour Comments MVC)
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
