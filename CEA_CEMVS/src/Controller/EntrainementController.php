<?php
namespace App\Controller;

use App\Entity\Entrainement;
use App\Form\EntrainementFormType;
use App\Form\DateCalendarEntrainementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrainementController extends Controller
{
    /**
     * @Route("/Entrainements/{saison}")
     */
    public function Entrainement(Request $request, $saison){
    	$Entrainements 	= new Entrainement();
        $form 			= $this->createForm(EntrainementFormType::class, $Entrainements, array("saison" => $saison));
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()) {

        	$form_entrainement = $request->request->get("entrainement_form");
            // Var fixe
            $libelle = $form_entrainement["Libelle"];
            $salle = $form_entrainement["Salle"];
            $tireurGroupe = $form_entrainement["tireurGroupe"];
            $entrainementType = $form_entrainement["entrainementType"];
        	foreach ($form_entrainement as $key => $value) {
        		$tmp = explode("_", $key);
        		if($tmp[0]=="Date"){
        			$day = substr("00".$tmp[1], (strlen($tmp[1])), 2);
					$month = $tmp[2];
					$year = $tmp[3];
					//variable pour bdd
					$date_time_deb = new \DateTime($day."/".$month."/".$year." ".$form_entrainement["HeureDebut"].":00", new \DateTimeZone("Europe/Paris"));
					$date_time_fin = new \DateTime($day."/".$month."/".$year." ".$form_entrainement["HeureFin"].":00", new \DateTimeZone("Europe/Paris"));
                    
                    $new_entrainement = new Entrainement();
                    $new_entrainement->setLibelle($libelle);
                    $new_entrainement->setSalle($salle);
                    $new_entrainement->setTireurGroupe($tireurGroupe);
                    $new_entrainement->setEntrainementType($entrainementType);

                    print_r($new_entrainement);
        		}
        	}

        	/*
            $em = $this->getDoctrine()->getManager();
            $em->persist($Entrainements);
            $em->flush();
            */
            //return $this->redirectToRoute('/Entrainements/'.$saison);
        }

        return $this->render('entrainement/entrainement.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/DateCalendarEntrainements")
     */
    public function DateCalendarEntrainement(Request $request){
        $form = $this->createForm(DateCalendarEntrainementType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()) {
        	//print_r($request->request->get("date_calendar_entrainement","Saison")["Saison"]);
            return $this->redirectToRoute('app_entrainement_entrainement',array(
            	"saison" => $request->request->get("date_calendar_entrainement","Saison")["Saison"],
            ));
        }

        return $this->render('entrainement/DateCalendarEntrainement.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}