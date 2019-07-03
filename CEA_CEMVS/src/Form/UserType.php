<?php
/**
 * Created by PhpStorm.
 * User: arino
 * Date: 03/12/2018
 * Time: 22:37
 */

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
           'attr' => array('class' => 'form-control mb-3 text-center'),
        ])
        ->add('rawpassword',PasswordType::class,[
            'label'=>'Votre mot de passe',
            'mapped'=>false,
           'attr' => array('class' => 'form-control mb-3 text-center','placeholder'=> '••••••••••••••'),
  
        ])
        ->add('nom',TextType::class,[
            "label"=> "Nom",
           'attr' => array('class' => 'form-control mb-3 text-center'),
        ])
        ->add('prenom',TextType::class,[
            "label"=> "Prenom",
           'attr' => array('class' => 'form-control mb-3 text-center'),
        ])
    
        
        ->add('role', ChoiceType::class, [
            'choices' => [
                'Admin' => 'admin',
                'Tireur' => 'tireur',
                'Maitre'   => 'maitre',
                
            ],
            'attr' => array('class' => 'form-control mb-3 text-center'),
           
        ]);



        $builder->addEventListener(FormEvents::PRE_SUBMIT,  function (FormEvent $event){
           /* dump($event->getForm());
            exit;*/
          /* dump($event->getData()).
           exit;*/
            $event->getForm()->getNormData()->setPassword($this->encoder->encodePassword($event->getForm()->getNormData(), $event->getData()['rawpassword']));
        });
    }


}