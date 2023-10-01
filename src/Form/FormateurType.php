<?php

namespace App\Form;

use App\Entity\Formateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FormateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, ['row_attr' => ['class' => 'formRow']])
        ->add('prenom', TextType::class, ['row_attr' => ['class' => 'formRow']])
        ->add('password', TextType::class, ['row_attr' => ['class' => 'formRow']])
        ->add('email', TextType::class, ['row_attr' => ['class' => 'formRow']])
        ->add('valider', SubmitType::class, ['row_attr' => ['class' => 'formRow']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formateur::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token', // The name of the CSRF field in your form
            'csrf_token_id' => 'your_csrf_token_id',
        ]);
    }
}
