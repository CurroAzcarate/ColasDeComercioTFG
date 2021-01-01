<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
Class giveEmail extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('email', EmailType::class, array(
                    'label' => 'Correo electrónico'
                ))
                ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ContactCaptcha',
                'label' => 'Copia los caracteres de la imagen'
                ))
                
                ->add('submit', SubmitType::class, array(
                    'label' => 'Enviar'
        ));
    }

}
