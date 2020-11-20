<?php

namespace App\Form;

use App\Entity\Pharmacy;
use App\Entity\Region;
use App\Entity\Zone;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PharmacyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('address')
            ->add('phoneNumber')
            ->add('points')
            ->add('region',EntityType::class,[
                'class'=>Region::class,
                'placeholder' => "Choose Region",
                'required'=>false,
                'mapped'=>false
                
            ])
            ->add('zone',EntityType::class,[
                'class'=>Zone::class,
                'placeholder' => "Choose Zone",
                'required'=>false,
                'mapped'=>false
                
            ])
            ->add('woreda')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pharmacy::class,
        ]);
    }
}
