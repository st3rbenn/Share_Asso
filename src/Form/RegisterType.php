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
                'class' => 'mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200',
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
                    'class' => 'mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200',
                ],
            ],
            'second_options' => [
                'label' => 'Confirmation du mot de passe',
                'attr' => [
                    'placeholder' => 'Confirmation du mot de passe',
                    'class' => 'mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200',
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
                    'class' => 'mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200',
                ],
            ])

            ->add('user_lastname', TextType::class, [
                'label' => 'Nom de famille',
                'required' => true,
                'attr' =>[
                    'placeholder' => 'Nom de famille',
                    'class' => 'mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200',
                ],
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'finaliser l\'inscription',
                'attr' => [
                    'class' => 'inline-flex justify-center rounded-lg text-sm font-semibold py-2.5 px-4 bg-slate-900 text-white hover:bg-slate-700 w-full',
                    'style' => 'background-color: #fb4e17;',
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
