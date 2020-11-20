<?php

namespace App\Form;

use App\Entity\HealthCare;
use App\Entity\Region;
use App\Entity\Zone;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HealthCareType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
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
            ->add('address')
            ->add('points')
            ->add('phoneNumber')
            ->add('type')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HealthCare::class,
        ]);
    }
}
