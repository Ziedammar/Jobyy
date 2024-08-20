<?php

namespace App\Form;

use App\Entity\Candidate;
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

class RegisterCType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class)
            ->add('password',PasswordType::class)
            ->add('type',HiddenType::class, [
        'data' => 0 ,
    ])
            ->add('nom', TextType::class)
            ->add('prenom',TextType::class)
            ->add('tel',NumberType::class)
            ->add('pays',TextType::class)
            ->add('gouvernorat',TextType::class)
            ->add('adresse',TextType::class)
            ->add('codePostal',NumberType::class)
            ->add('birthday',DateType::class,[
                'years' => range('1970',date("Y")-18)
                ])
            ->add('profilePic',FileType::class)
            ->add('cv',FileType::class)
            ->add('about_you',TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidate::class,
        ]);
    }
}
