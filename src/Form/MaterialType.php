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
                ],
            ])

            ->add('material_description', TextType::class, [
                'label' => 'Description du matériel',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Description du matériel',
                ],
            ])

            ->add('material_img', FileType::class, [
                'required' => true,
                'data_class' => null,
                'data' => null,
                'attr' => [
                    'class' => 'form-control m-2',
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
                'label' => 'Ajouter',
                'attr' => [
                    'class' => 'btn btn-primary m-2',
                ],
            ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Material::class,
        ]);
    }
}
