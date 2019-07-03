<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends Controller
{
    /**
     * @Route("/TEST")
     */
    public function TEST(){
		$MOIS_DEBUT 	= 11;
		$MOIS_FIN 		= 2;
    	$ANNEE_DEBUT 	= 2019;
    	$ANNEE_FIN 		= 2021;

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
                                "num_jour" 	=> date("j",$ma_date),
                                "nom_jour" 	=> date("l",$ma_date),
                                "mois" 		=> date("F",$ma_date),
                                "annee" 	=> date("Y",$ma_date));
	    			array_push($calendar, $mon_array_date);
	    		}
	    	}
    	}

/*    	Exemple de parseur pour afficher le calendrier.
		foreach ($calendar as $key => $value) {
			foreach ($value as $k => $v) {
				if ($k != "all") {
					print_r(" ".$v);
				}
			}
			if (isset($calendar[$key+1]) && $calendar[$key+1]["num_jour"] < $calendar[$key]["num_jour"]) {
		    	print_r("<hr>");
			}
    		print_r("<br>");
    	}
*/
        // Renvoi de la réponse
        return new Response('<br>Tested ! Busted !');
    }

/*	Fonction incomplète de traduction des date en FR
    private function TradDateFr($date){
    	preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/", $date, $regs);
		$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
		$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
		$datefr = $jour[date("w",mktime(0, 0, 0, $regs[2], $regs[3], $regs[1]))];
		$datefr .= " ".date("d",mktime(0, 0, 0, $regs[2], $regs[3], $regs[1]));
		$datefr .= " ".$mois[date("n",mktime(0, 0, 0, $regs[2], $regs[3], $regs[1]))];
		$datefr .= " ".date("Y",mktime(0, 0, 0, $regs[2], $regs[3], $regs[1]));
		return $datefr;
    }
*/
}