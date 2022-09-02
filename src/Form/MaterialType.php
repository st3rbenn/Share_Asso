<?php

namespace App\Form;

use App\Entity\Material;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MaterialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('material_name', TextType::class, [
                'label' => 'Nom du matériel',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nom du matériel',
                    'class' => 'mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200'
                ],
            ])

            ->add('material_description', TextType::class, [
                'label' => 'Description du matériel',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Description du matériel',
                    'class' => 'mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200'
                ],
            ])

            ->add('material_img', FileType::class, [
                'required' => false,
                'data_class' => null,
                'data' => null,
                'attr' => [
                    'class' => 'mt-2 appearance-none text-slate-900 bg-white rounded-md block w-full px-3 h-10 shadow-sm sm:text-sm focus:outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 ring-1 ring-slate-200',
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

            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter le matériel',
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
            'data_class' => Material::class,
        ]);
    }
}
