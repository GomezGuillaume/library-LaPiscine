<?php

namespace App\Form;

use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, [
                "label" => "Nom"
            ])
            ->add('lastname', null, [
                "label" => "Prénom"
            ])
            ->add('birthdate', DateType::class, [
                "widget" => "single_text",
                "label" => "Date de naissance"
            ])
            ->add('deathdate', DateType::class, [
                "widget" => "single_text",
                "label" => "Décès"
            ])
            ->add('biography', null, [
                "label" => "Biographie"
            ])
            ->add('published', null, [
                "label" => "Publié le"
            ])
            ->add("submit", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
