<?php 


namespace App\Form  ;

use App\Data\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    { 
        $builder 
      
            ->add ('min' , DateType::class , [
                'required' => false  , 
                'label' => 'date min ' ,
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'  ]

            ])  
            ->add ('max' , DateType::class , [
                'required' => false  , 
                'label' => 'date max' ,
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'  ]

            ])  
            ->add ('c' , TextType::class , [
                'required' => false  , 
                'label'=> false , 
                'attr' => ['class' => 'form-control' , 'placeholder'=>'Chercher'  ]

            ])  ; 
         
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=> SearchData :: class , 
            'method' => 'GET' , 
            'csrf_protection' => false  
        ]); 

    }
    public function getBlockPrefix()
    {
        return '' ; 
    }


}