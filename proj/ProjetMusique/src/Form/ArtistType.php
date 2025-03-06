<?php

namespace App\Form;

use App\Entity\Artist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;

class ArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('imageFile', FileType::class, [
                'label' => 'Image (JPEG, PNG)',
                'mapped' => false, // Ne pas lier directement à l'entité
                'required' => false, // Assurez-vous que ce champ est bien rempli
                'constraints' => [
                    new Image([
                        'maxSize' => '25M',
                        'mimeTypes' => ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'], // Add png here
                        'mimeTypesMessage' => 'Please upload a valid image (jpeg, png, gif).'
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artist::class,
        ]);
    }
}