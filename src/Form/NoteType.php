<?php

namespace App\Form;

use App\Entity\Folder;
use App\Entity\Langage;
use App\Entity\Note;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\SecurityBundle\Security;
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
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();
        // On récupère l'utilisateur connecté
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre de la Note : ',
            ])
            ->add('code', TextareaType::class, [
                'label' => 'Code de la Note : ',
                'required' => true,
                'row_attr' => [
                    'class' => 'div-note',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description de la Note : ',
                'required' => false,
                'attr' => ['class' => 'description'],
            ])
            ->add('img', FileType::class, [
                'label' => 'Image : ',
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
                'label' => 'Langage : ',
                'class' => Langage::class,
                'choice_label' => 'display_name',
            ])
            ->add('tag', EntityType::class, [
                'label' => 'Tag : ',
                'class' => Tag::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
                'query_builder' => function (EntityRepository $tagrepository) use ($user) {
                // query_builder permet de personnaliser la requête
                // Définit une fonction anonyme avec en parametre le repository de l'entité Tag
                    return $tagrepository->createQueryBuilder('tag')
                // Crée un QueryBuilder pour l'entité Tag
                        ->where('tag.user = :user')
                        ->setParameter('user', $user);
                // est egal a la requte slq SELECT * FROM tag t WHERE t.user = :user;
                
                },
            ])
            ->add('folder', EntityType::class, [
                'label' => 'Dossier : ',
                'class' => Folder::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
                'query_builder' => function (EntityRepository $folderrepository) use ($user) {
                        return $folderrepository->createQueryBuilder('folder')
                            ->where('folder.user = :user')
                            ->setParameter('user', $user);
                    
                    },
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
