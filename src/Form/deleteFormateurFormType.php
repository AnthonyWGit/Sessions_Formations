<?php

namespace App\Form;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class deleteFormateurFormType extends AbstractType
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    { 
        $builder
        ->add('username', EntityType::class, [ //Must find a way to display only sessions that have not ended yet
            "class" => User::class,
            "choice_label" => "username",
            "multiple" => true,
            'query_builder' => function (UserRepository $er) use ($options)
                {
                return $er->createQueryBuilder('u') //Here we don't want to display sessions that are end meaning we select only sesions where endDate are at least tomorrow
                    ->where('u.username !=  :admin')
                    ->setParameter('admin', $options["ok"])
                    ->orderBy('u.username', 'ASC');
            },
        ])
        ->add('valider', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token', 
            'csrf_token_id' => 'your_csrf_token_id',
            'ok' => null,
        ]);
    }
}
