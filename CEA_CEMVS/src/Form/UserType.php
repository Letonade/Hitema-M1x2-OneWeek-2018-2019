<?php
/**
 * Created by PhpStorm.
 * User: arino
 * Date: 03/12/2018
 * Time: 22:37
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserType extends AbstractType
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login',TextType::class,[
           "label"=> "Login",
        ])
        ->add('rawpassword',TextType::class,[
            'label'=>'Votre mot de passe',
            'mapped'=>false,
        ])
        ->add('nom',TextType::class,[
            "label"=> "Nom",
        ])
        ->add('prenom',TextType::class,[
            "label"=> "Prenom",
        ])
        ;


        $builder->addEventListener(FormEvents::PRE_SUBMIT,  function (FormEvent $event){
           /* dump($event->getForm());
            exit;*/
          /* dump($event->getData()).
           exit;*/
            $event->getForm()->getNormData()->setPassword($this->encoder->encodePassword($event->getForm()->getNormData(), $event->getData()['rawpassword']));
        });
    }


}