<?php

namespace App\Form;

use App\Document\Comments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bundle\SecurityBundle\Security;

class CommentsType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
