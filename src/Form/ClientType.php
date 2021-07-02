<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\DeliveryAdressType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null,[
                'required' => true
            ])
            ->add('firstname', null,[
                'required' => true
            ])
            ->add('email', null,[
                'required' => true
            ])
            ->add('adress', null,[
                'required' => true
            ])
            ->add('complement_adress')
            ->add('city', null,[
                'required' => true
            ])
            ->add('cp', null,[
                'required' => true
            ])
            ->add('country', ChoiceType:: class, [
                'choices' => [
                    'France' => 'France',
                    'Luxembourg' => 'Luxembourg',
                    'Belgique' => 'Belgique',
                ]
            ])
            ->add('tel', null,[
                'required' => true
            ])
            ->add('delivery', DeliveryAdressType:: class)   
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
