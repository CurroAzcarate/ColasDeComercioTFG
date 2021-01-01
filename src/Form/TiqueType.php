<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

Class TiqueType extends AbstractType{
  
    
    public function buildForm(FormBuilderInterface $builder,array $options){
        
        $builder->add('codigo',TextType::class, array(
            'disabled' =>true,
            'label'=>'Codigo'
            
        ))
                
                ->add('estado',ChoiceType::class, array(
            'label'=>'Estado del tiquet',
                    
            'choices'=>array(
               'EN ESPERA'=>'EN ESPERA',
               'DESPACHANDO' =>'DESPACHANDO',
               'DESPACHADO' =>'DESPACHADO'
                
        
            )
        ))
               
                ->add('submit',SubmitType::class, array(
            'label'=>'Guardar'
        ));
    }
}