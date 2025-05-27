<?php

// src/Form/NotificationSubscriberType.php
namespace App\Form;

use App\Entity\NotificationSubscriber;
use Symfony\Component\Form\AbstractType;
use App\Repository\NotificationSubscriberRepository;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NotificationSubscriberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Entrez votre email', 'class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NotificationSubscriber::class,
        ]);
    }
}
