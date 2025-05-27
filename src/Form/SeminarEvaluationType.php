<?php

namespace App\Form;

use App\Entity\Seminar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeminarEvaluationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Validé' => 'validé',
                    'Rejeté' => 'rejeté',
                    'En attente' => 'en attente',
                ],
                'placeholder' => '-- Sélectionnez un statut --',
                'required' => true,
            ])
            ->add('commentaire', TextareaType::class, [
                'label' => 'Commentaire',
                'required' => false,
                'attr' => ['rows' => 5],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Seminar::class,
        ]);
    }
}
