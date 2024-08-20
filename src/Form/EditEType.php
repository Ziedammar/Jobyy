<?php

namespace App\Form;

use App\Entity\Entreprise;
use phpDocumentor\Reflection\File;
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

class EditEType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class, array('data_class' => null))
            ->add('password',PasswordType::class, array('data_class' => null))

            ->add('nom',TextType::class, array('data_class' => null))
            ->add('About',TextareaType::class, array('data_class' => null))
            ->add('adresse',TextType::class, array('data_class' => null))
            ->add('tel',NumberType::class, array('data_class' => null))
            ->add('siteweb',TextType::class, array('required'   => false,'data_class' => null))
            ->add('twitter',TextType::class, array('required'   => false,'data_class' => null))
            ->add('linkdin',TextType::class, array('required'   => false,'data_class' => null))
            ->add('facebook',TextType::class, array('required'   => false,'data_class' => null))
            ->add('profilPic',FileType::class, array('required'   => false,'data_class' => null))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
