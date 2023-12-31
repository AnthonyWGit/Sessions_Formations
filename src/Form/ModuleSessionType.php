<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Categorie;
use App\Entity\Programme;
use App\Entity\ModuleSession;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ModuleSessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'row_attr' => ['class' => 'formRow'],
        ])
        ->add('categorie', EntityType::class, [
            'class' => Categorie::class,
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
            'data_class' => ModuleSession::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token', // The name of the CSRF field in your form
            'csrf_token_id' => 'your_csrf_token_id',
        ]);
    }
}
