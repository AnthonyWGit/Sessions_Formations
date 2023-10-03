<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Formateur;
use App\Entity\Formation;
use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre' , TextType::class, [

            ])
            ->add('dateSessionDebut', DateType::class, [
                'widget' =>'single_text',

            ])
            ->add('dateSessionFin', DateType::class, [
                'widget' =>'single_text',
                'constraints' => [
                    new NotBlank(), 
                    new GreaterThan([
                        'message' => 'La date de fin doit être supérieure à celle de début',
                        'propertyPath' => 'parent.all[dateSessionDebut].data' //Thanks StackOverflow 
                    ])
                ]
            ])
            ->add('places', NumberType::class, [

            ])
            ->add('formation', EntityType::class, [
                'class' => Formation::class,

            ])
            ->add('formateur', EntityType::class , [
                'class' => Formateur::class,
            ])

            ->add('coordonnees', TextType::class, ['attr' => ['class' => 'coordinates']])

            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token', // The name of the CSRF field in your form
            'csrf_token_id' => 'your_csrf_token_id',
        ]);
    }
}
