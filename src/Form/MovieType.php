<?php

namespace App\Form;

use App\Entity\Movie;
use App\Entity\movieDirector;
use App\Entity\MovieGenre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('movieTitle')
            ->add('yearReleased')
            ->add('movieDuration')
            ->add('filmography', EntityType::class, [
                'class' => movieDirector::class,
                'choice_label' => 'name',
            ])
            ->add('Genre', EntityType::class, [
                'class' => MovieGenre::class,
                'choice_label' => 'typeName',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
