<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Genre;
use phpDocumentor\Reflection\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BooksFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                "label" => "Titre",
                "required" => false
            ])

            ->add('NbPages', null, [
                "required" => false
            ])

            ->add("genre", EntityType::class, [
                "class" => Genre::class,
                "choice_label" => "name"
            ])

            ->add("author", EntityType::class, [
                "class" => Author::class,
                "choice_label" => "lastname"
            ])

            ->add('resume', null, [
                "required" => false
            ])

            ->add('bookCover', FileType::class, [
                'mapped' => false
            ])

            ->add("submit", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
