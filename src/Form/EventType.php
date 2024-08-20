<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categorie',TextType::class,array('data_class' => null))
            ->add('nom',TextType::class,array('data_class' => null))
            ->add('nbr',NumberType::class,array('data_class' => null))
            ->add('date',DateType::class,array('data_class' => null))
            ->add('datefin',DateType::class,array('data_class' => null))
            ->add('image',FileType::class,array('data_class' => null))
            ->add('description', TextareaType::class, [
                'attr' => array('cols' => '30', 'rows' => '5'),
                'data_class' => null
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
