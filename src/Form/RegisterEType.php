<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegisterEType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class)
            ->add('password',PasswordType::class)
            ->add('type',HiddenType::class, [
                'data' => 1 ,
            ])
            ->add('nom', TextType::class)
            ->add('About',TextareaType::class)
            ->add('adresse', TextType::class)
            ->add('tel', NumberType::class)
            ->add('siteweb', TextType::class, [
                'required'   => false,
            ])
            ->add('twitter', TextType::class, [
                'required'   => false,

            ])
            ->add('linkdin', TextType::class, [
        'required'   => false,
    ])
            ->add('facebook', TextType::class, [
        'required'   => false,

    ])
            ->add('profilPic', FileType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
