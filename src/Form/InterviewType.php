<?php

namespace App\Form;

use App\Entity\Interview;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class InterviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_temps' ,DateTimeType::class ,[
                'widget' => 'single_text',


            ] )
            
            ->add('abreviation' ,TextType::class ,[

            ] )
            ->add('Ajouter', SubmitType::class, [
                'attr' => ['class' => 'save']
                 ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Interview::class,
        ]);
    }
}
