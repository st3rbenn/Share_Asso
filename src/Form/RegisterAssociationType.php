<?php

namespace App\Form;

use App\Entity\Association;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RegisterAssociationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('association_name', TextType::class, [
                'label' => 'Nom de l\'association',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nom de l\'association',
                    'class' => 'mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200',
                ],
            ])
            ->add('association_phone', TelType::class, [
                'label' => 'Numéro de téléphone',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Numéro de téléphone',
                    'class' => 'mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200',
                ],
            ])
            ->add('association_address', TextType::class, [
                'label' => 'Adresse',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Adresse',
                    'class' => 'mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200',
                ],
            ])
            ->add('association_zipcode', TextType::class, [
                'label' => 'Code postal',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Code postal',
                    'class' => 'mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200',
                ],
            ])
            ->add('association_city', TextType::class, [
                'label' => 'Ville',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ville',
                    'class' => 'mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200',
                ],
            ])
            ->add('association_img', FileType::class, [
                'required' => false,
                'data_class' => null,
                'data' => null,
                'attr' => [
                    'class' => 'cursor-pointer relative block opacity-0 w-full h-full p-10 z-50',
                    'type' => 'file',
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp'
                        ],
                        'mimeTypesMessage' => 'Merci de choisir un fichier de type jpeg, png ou webp',
                    ])
                ],
            ])
            ->add('association_website', TextType::class, [
                'label' => 'Site internet',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Site internet',
                    'class' => 'mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Association::class,
        ]);
    }
}
