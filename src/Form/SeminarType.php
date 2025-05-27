<?php

namespace App\Form;

use App\Entity\Seminar;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeminarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('summary', TextareaType::class, [
                'label' => 'Résumé',
            ])
            ->add('date', DateTimeType::class, [
                'label' => 'Date et heure',
                'widget' => 'single_text',
                'html5' => true,
            ])
             ->add('file', FileType::class, [
        'label' => 'Fichier joint (PDF ou autre)',
        'required' => false,
        'mapped' => false
             ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Seminar::class,
        ]);
    }
}