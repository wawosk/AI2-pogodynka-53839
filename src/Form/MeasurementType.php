<?php

namespace App\Form;

use App\Entity\Measurement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Location;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'city',
                'attr' => ['class' => 'form-control'],
                'required' => false, // WYŁĄCZ required HTML5
            ])
            ->add('day', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'required' => false, // WYŁĄCZ required HTML5
            ])
            ->add('celsius', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'np. 25'
                ],
                'required' => false, // WYŁĄCZ required HTML5
            ])
            ->add('humidity', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'np. 65'
                ],
                'required' => false, // WYŁĄCZ required HTML5
            ])
            ->add('rainprob', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'np. 30'
                ],
                'required' => false, // WYŁĄCZ required HTML5
            ])
            ->add('wind', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'np. 15'
                ],
                'required' => false, // WYŁĄCZ required HTML5
            ])
            ->add('forecast', ChoiceType::class, [
                'choices' => [
                    'Słonecznie' => 'słonecznie',
                    'Pochmurno' => 'pochmurno',
                    'Deszczowo' => 'deszczowo',
                    'Śnieg' => 'śnieg',
                    'Burza' => 'burza',
                    'Mgła' => 'mgła',
                ],
                'attr' => ['class' => 'form-control'],
                'required' => false, // WYŁĄCZ required HTML5
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
        ]);
    }
}
