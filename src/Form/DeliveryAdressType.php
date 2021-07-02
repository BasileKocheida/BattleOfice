<?php

namespace App\Form;

use App\Entity\DeliveryAdress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeliveryAdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('firstname')
            ->add('adress')
            ->add('complement_adress')
            ->add('city')
            ->add('cp')
            ->add('country', ChoiceType:: class, [
                'choices' => [
                    'France' => 'France',
                    'Luxembourg' => 'Luxembourg',
                    'Belgique' => 'Belgique',
                ]
            ])
            ->add('tel')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DeliveryAdress::class,
        ]);
    }
}
