<?php

namespace App\Form;

use App\Entity\Ambulance;
use App\Entity\Region;
use App\Entity\Zone;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AmbulanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plate')
            ->add('owner')
            ->add('gps')
            ->add('status',ChoiceType::class,[
                'choices' =>[
                    'Available'=>'1',
                    'Dispatched'=>'2',
                    'Inactive'=>'3',
                ],
                'placeholder' => "Choose Status",
                'required'=>true,
                  
                ])
            ->add('primaryLocation')
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ambulance::class,
        ]);
    }
}
