<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            'label' => 'Email',
            'required' => true,
            'attr' => [
                'placeholder' => 'Renseignez votre email',
                'class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm',
            ],
        ])
        
        ->add('password', RepeatedType::class, [
            'label' => '',
            'type' => PasswordType::class,
            'invalid_message' => 'Les mots de passe doivent correspondre',
            'required' => true,
            'first_options' => [
                'label' => 'Mot de passe',
                'attr' => [
                    'placeholder' => 'Renseignez votre mot de passe',
                    'class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm',
                ],
            ],
            'second_options' => [
                'label' => 'Confirmation du mot de passe',
                'attr' => [
                    'placeholder' => 'Confirmation du mot de passe',
                    'class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm',
                ],
            ],
            'constraints' => [
                new Regex([
                    'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
                    'message' => 'Le mot de passe doit contenir au moins une majuscule, une minucsule, un chiffre, aucun caractère spécial et 8 caractères'
                ])
            ],
        ])

            ->add('user_firstname', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Prénom',
                    'class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm',
                ],
            ])

            ->add('user_lastname', TextType::class, [
                'label' => 'Nom de famille',
                'required' => true,
                'attr' =>[
                    'placeholder' => 'Nom de famille',
                    'class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm',
                ],
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
                'attr' => [
                    'class' => 'ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2',
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
