<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => false, // WYŁĄCZ required HTML5
            ])
            ->add('country', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => false, // WYŁĄCZ required HTML5
            ])
            ->add('latitude', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'np. 52.2296756'
                ],
                'required' => false, // WYŁĄCZ required HTML5
            ])
            ->add('longitude', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'np. 21.0122287'
                ],
                'required' => false, // WYŁĄCZ required HTML5
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
