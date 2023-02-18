<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('author', TextType::class, [
                'row_attr' => [
                    'class' => 'col-6 mb-3',
                ],
            ])
            ->add('email', EmailType::class, [
                'row_attr' => [
                    'class' => 'col-6 mb-3',
                ],
            ])
            ->add('content', TextareaType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'Add comment',
                'attr' => [
                    'class' => 'btn-success'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class
        ]);
    }
}
