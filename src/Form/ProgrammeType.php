<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Programme;
use App\Entity\ModuleSession;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('session', EntityType::class, [
                'class' => Session::class,
                'row_attr' => ['class' => 'formRow'],
            ])
            ->add('module_session', EntityType::class, [
                'class' => ModuleSession::class,
                'row_attr' => ['class' => 'formRow'],
            ])
            ->add('nbJours', NumberType::class, [
                'row_attr' => ['class' => 'formRow'],
            ])
            ->add('valider', SubmitType::class, [
                'row_attr' => ['class' => 'formRow'],
            ])
        ;
    }    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Programme::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token', // The name of the CSRF field in your form
            'csrf_token_id' => 'your_csrf_token_id',
        ]);
    }
}
