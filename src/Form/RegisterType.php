<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;

Class RegisterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', TextType::class, array(
                    'label' => 'Nombre'
                ))
                ->add('surname', TextType::class, array(
                    'label' => 'Apellidos'
                ))
                ->add('email', EmailType::class, array(
                    'label' => 'Correo electrónico'
                ))
                
               
                
                ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repetir Password'),
                    )
                )
                ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ContactCaptcha',
                'label' => 'Copia los caracteres de la imagen'
                ))
                
                ->add('submit', SubmitType::class, array(
                    'label' => 'Registrar'
        ));
        
    }

}
