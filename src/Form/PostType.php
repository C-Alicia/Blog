<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', options: [
                "attr" => ["class" => "form-control mb-3"],

            ])
            ->add('description', options: [
                "attr" => ["class" => "form-control mb-3"],

            ])
            ->add('contenu',  options: [
                "attr" => ["class" => "form-control mb-3"],
            ])

            ->add('Category', EntityType::class, [
                // looks for choices from this entity
                'class' => Category::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'name',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,

                "attr" => ["class" => "alert alert-light my-3"]

            ])
            
           /*  ->add('ImageFileName') */

            ->add('Envoyer', SubmitType::class, [
                "attr" => ["class" => "btn btn-secondary my-3"]
            ]);


            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
