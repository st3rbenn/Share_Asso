<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            'label' => '>Email',
            'required' => true,
            'attr' => [
                'placeholder' => 'Renseignez votre email',
            ],
        ])
        
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Les mots de passe doivent correspondre',
            'required' => true,
            'first_options' => [
                'label' => 'Mot de passe',
                'attr' => [
                    'placeholder' => 'Renseignez votre mot de passe',
                ],
            ],
            'second_options' => [
                'label' => 'Confirmation du mot de passe',
                'attr' => [
                    'placeholder' => 'Confirmation du mot de passe',
                ],
            ],
            'constraints' => [
                new Regex([
                    'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
                    'message' => 'Le mot de passe doit contenir au moins une majuscule, une minucsule, un chiffre et 8 caractères'
                ])
            ],
        ])

            ->add('user_firstname', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Prénom',
                ],
            ])

            ->add('user_lastname', TextType::class, [
                'label' => 'Nom de famille',
                'required' => true,
                'attr' =>[
                    'placeholder' => 'Nom de famille',
                ],
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
