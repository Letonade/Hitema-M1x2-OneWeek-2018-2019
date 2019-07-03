<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\EntrainementType;
use App\Entity\TireurGroupe;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrainementFormType extends AbstractType
{
	private $calendar;

    public function __construct()
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->calendar = $this->makeCalendar(6,6, $options["saison"], $options["saison"]+1);

        $builder->add('Libelle',TextType::class,[
           "label"=> "Libelle",
           'attr' => array('class' => 'form-control'),
        ])
        ->add('HeureDebut',TextType::class,[
            'label'=>'Heure de début',
            'mapped'=>false,
           'attr' => array('class' => 'form-control'),
        ])
        ->add('HeureFin',TextType::class,[
            'label'=>'Heure de fin',
            'mapped'=>false,
           'attr' => array('class' => 'form-control'),
        ])
        ->add('Salle',TextType::class,[
            'label'=>'Salle',
           'attr' => array('class' => 'form-control'),
        ])
        ->add('entrainementType',EntityType::class,[
            'label'=>'Type',
            'class'=> EntrainementType::class,
           'attr' => array('class' => 'form-control'),
        ])
        ->add('tireurGroupe',EntityType::class,[
            'label'=>'Groupe',
            'class'=> TireurGroupe::class,
           'attr' => array('class' => 'form-control'),
        ])
        ;
        foreach ($this->calendar as $key => $value) {
        	$builder->add('Date_'.$value["allUnder"],CheckboxType::class,[
			"label"=>$value["all"],
            'mapped'=>false,
            'required'=>false,
			]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
        'saison' => '2019',
        ));
    }

    private function makeCalendar($MOIS_DEBUT, $MOIS_FIN, $ANNEE_DEBUT, $ANNEE_FIN){
    	$calendar = array();
    	for ($annee_actuel = $ANNEE_DEBUT; $annee_actuel <= $ANNEE_FIN; $annee_actuel++){
    		$mon_mois_debut = ($annee_actuel == $ANNEE_DEBUT)? $MOIS_DEBUT : 1;
    		$mon_mois_fin = ($annee_actuel == $ANNEE_FIN)? $MOIS_FIN : 12;
	    	for ($mois_actuel = $mon_mois_debut ; $mois_actuel <= $mon_mois_fin; $mois_actuel++){
	    		$mon_mois = mktime(0, 0, 0, $mois_actuel, 1, $annee_actuel);
	    		for ($jour_mois_actuel = 1; $jour_mois_actuel <= (int)date("t", $mon_mois); $jour_mois_actuel++){
	    			$ma_date = mktime(0, 0, 0, $mois_actuel, $jour_mois_actuel, $annee_actuel);
	    			$mon_array_date = array(//on créer un tableau de chaque journée.
                                "all" 		=> date("j l F Y",$ma_date),
                                "allUnder"	=> date("j_m_Y",$ma_date),
                                "num_jour" 	=> date("j",$ma_date),
                                "nom_jour" 	=> date("l",$ma_date),
                                "mois" 		=> date("F",$ma_date),
                                "annee" 	=> date("Y",$ma_date));
	    			array_push($calendar, $mon_array_date);
	    		}
	    	}
    	}
    	return $calendar;
    }

}