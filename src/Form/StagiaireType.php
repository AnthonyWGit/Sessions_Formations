<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Repository\SessionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom' , TextType::class)
            ->add('prenom', TextType::class)
            ->add('dateDeNaissance', DateType::class , [
                'widget' =>'single_text',
            ])
            ->add('email', TextType::class)
            ->add('sessions', EntityType::class, [ //Must find a way to display only sessions that have not ended yet
                "class" => Session::class,
                "choice_label" => "titre",
                "multiple" => true,
                'query_builder' => function (SessionRepository $er) { //Query builder allows us to do custom queries to matche specific conditions
                    return $er->createQueryBuilder('s') //Here we don't want to display sessions that are end meaning we select only sesions where endDate are at least tomorrow
                        ->where('s.dateSessionFin > :currentDate')
                        ->setParameter('currentDate', new \DateTime())
                        ->orderBy('s.dateSessionFin', 'ASC');
                },
            ])
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}
