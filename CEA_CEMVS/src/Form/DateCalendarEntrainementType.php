<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DateCalendarEntrainementType extends AbstractType
{
	private $tab_saison;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
    	$this->tab_saison = array();
    	for ($i=2018; $i < 2050; $i++) { 
    		$this->tab_saison["saison ".$i." - ".($i+1)] = $i;
    	}
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Saison',ChoiceType::class,[
           "label"=> "Saison",
           "choices"=> $this->tab_saison,
           'attr' => array('class' => 'form-control'
                ),
        ])->add('Ajout',SubmitType::class,[
           "label"=> "Ajouts d'entrainements",
           'attr' => array('class' => 'btn btn-primary'
                ),
        ])->add('Visuel',SubmitType::class,[
           "label"=> "Table des entrainements",
           'attr' => array('class' => 'btn btn-primary'
                ),
        ])
        ;
    }
}