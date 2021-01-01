<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

Class NegocioType extends AbstractType{
  
    
    public function buildForm(FormBuilderInterface $builder,array $options){
        $builder->add('nombre',TextType::class, array(
            'label'=>'Nombre'
        ))
                ->add('descripcion',TextareaType::class, array(
            'label'=>'Descripcion'
        ))
                
                ->add('submit',SubmitType::class, array(
            'label'=>'Guardar'
        ));
    }
}