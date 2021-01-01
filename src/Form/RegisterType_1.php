<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
Class RegisterType_1 extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('role', ChoiceType::class, array(
                    
                    'label' => 'Rol',
                    'choices' => array(
                        'CLIENTE' => 'CLIENTE',
                        'ADMINISTRADOR' => 'ADMINISTRADOR',
                        'VENDEDOR' => 'VENDEDOR'
                        
                    )
                ))
                ->add('name', TextType::class, array(
                    'label' => 'Nombre'
                ))
                ->add('surname', TextType::class, array(
                    'label' => 'Apellidos'
                ))
                ->add('email', EmailType::class, array(
                    'label' => 'Correo electrónico'
                ))
                ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ContactCaptcha',
                'label' => 'Copia los caracteres de la imagen'
                ))
                
                ->add('submit',SubmitType::class, array(
                    
                    'label' => 'Guardar'
        ));
    }

}
