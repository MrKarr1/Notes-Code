<?php

namespace App\Form;

use App\Entity\Folder;
use App\Entity\Langage;
use App\Entity\Note;
use App\Entity\Tag;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\File;


class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre de la Note: '
            ])
            ->add('code', TextareaType::class, [
                'label' => 'Code de la Note'
            ])
            ->add('description', TextType::class, [
                'label' => 'Description de la Note: '
            ])
            ->add('img', FileType::class, [
                'label' => 'Image: ',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5000k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Image trop lourde',
                    ])
                ],
            ])
            ->add('is_favori', CheckboxType::class, [
                'label' => 'Favori ?  ',
                'required' => false,
            ])
            ->add('langage', EntityType::class, [
                'label' => 'Langage :',
                'class' => Langage::class,
                'choice_label' => 'display_name',
            ])
            ->add('tags', EntityType::class, [
                'label' => 'Tag :',
                'class' => Tag::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
            ->add('folders', EntityType::class, [
                'label' => 'Dossier :',
                'class' => Folder::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
