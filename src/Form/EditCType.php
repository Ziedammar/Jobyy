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

class EditCType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class, array('data_class' => null))
            ->add('password',PasswordType::class, array('data_class' => null))
            ->add('nom', TextType::class, array('data_class' => null))

            ->add('prenom',TextType::class, array('data_class' => null))
            ->add('tel',NumberType::class, array('data_class' => null))
            ->add('pays',TextType::class, array('data_class' => null))
            ->add('gouvernorat',TextType::class, array('data_class' => null))
            ->add('adresse',TextType::class, array('data_class' => null))
            ->add('codePostal',NumberType::class, array('data_class' => null))
            ->add('birthday',DateType::class, array('data_class' => null,'years' => range('1970',date("Y")-18)
            ))
            ->add('profilePic',FileType::class, array('required'   => false,'data_class' => null))
            ->add('cv',FileType::class, array('required'   => false,'data_class' => null))
            ->add('about_you',TextareaType::class, array('data_class' => null))
        ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidate::class,
        ]);
    }
}
