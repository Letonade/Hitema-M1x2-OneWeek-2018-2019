<?php
namespace App\Controller;

use App\Entity\Competition;
use App\Form\CompetitionType;
use App\Form\DateCalendarEntrainementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompetitionController extends Controller
{
    /**
     * @Route("/EntrainementsAdd/{saison}")
     */
    public function EntrainementAdd(Request $request, $saison){
    	$Entrainements 	= new Entrainement();
        $form 			= $this->createForm(EntrainementFormType::class, $Entrainements, array("saison" => $saison));
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $tireurGroupeRepository = $em->getRepository(TireurGroupe::class);
            $entrainementTypeRepository = $em->getRepository(EntrainementType::class);

        	$form_entrainement = $request->request->get("entrainement_form");
            // Var fixe
            $libelle = $form_entrainement["Libelle"];
            $salle = $form_entrainement["Salle"];
            $tireurGroupe = $tireurGroupeRepository->findOneBy(['id'=>$form_entrainement["tireurGroupe"]]);
            $entrainementType = $entrainementTypeRepository->findOneBy(['id'=>$form_entrainement["entrainementType"]]);
            foreach ($form_entrainement as $key => $value) {
                $tmp = explode("_", $key);
                if($tmp[0]=="Date"){
                    $day = substr("00".$tmp[1], (strlen($tmp[1])), 2);
                    $month = $tmp[2];
                    $year = $tmp[3];
                    //variable pour bdd
                    $date_time_deb = new \DateTime($day."-".$month."-".$year." ".$form_entrainement["HeureDebut"].":00", new \DateTimeZone("Europe/Paris"));
                    $date_time_fin = new \DateTime($day."-".$month."-".$year." ".$form_entrainement["HeureFin"].":00", new \DateTimeZone("Europe/Paris"));
                    
                    $new_entrainement = new Entrainement();
                    $new_entrainement->setLibelle($libelle);
                    $new_entrainement->setSalle($salle);
                    $new_entrainement->setTireurGroupe($tireurGroupe);
                    $new_entrainement->setEntrainementType($entrainementType);
                    $new_entrainement->setDateDebut($date_time_deb);
                    $new_entrainement->setDateFin($date_time_fin);
                    $em->persist($new_entrainement);
                    //print_r($day."/".$month."/".$year." ".$form_entrainement["HeureDebut"].":00");

                }
            }
            $em->flush();
            /*
            $em = $this->getDoctrine()->getManager();
            $em->persist($Entrainements);
            $em->flush();
            */
            //return $this->redirectToRoute('/Entrainements/'.$saison);
        }

        return $this->render('entrainement/entrainementAdd.html.twig', [
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
            if ($form->get('Ajout')->isClicked()){
                return $this->redirectToRoute('app_entrainement_entrainementadd',array(
                    "saison" => $request->request->get("date_calendar_entrainement","Saison")["Saison"],
                ));
            }elseif ($form->get('Visuel')->isClicked()){
                return $this->redirectToRoute('app_entrainement_entrainementlist',array(
                    "saison" => $request->request->get("date_calendar_entrainement","Saison")["Saison"],
                ));
            }
        }

        return $this->render('entrainement/DateCalendarEntrainement.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/Entrainements/{saison}")
     */
    public function EntrainementList(Request $request, $saison){
        $em=$this->getDoctrine()->getManager();
        $EntrainementRepository     = $em->getRepository(Entrainement::class);
        $Entrainements              = $EntrainementRepository->findAll();

        return $this->render('entrainement/entrainementListe.html.twig', [
            'Entrainements' => $Entrainements,
            'saison' => $saison,
        ]);
    }

    /**
     * @Route("/Entrainements/{id}/supprimer", requirements={"id":"\d+"}, name="deleteEntrainement")
     */
    public function deleteEntrainementAction(Entrainement $Entrainement,Request $request)
    {
        $token = $request->query->get('token');
        $saison = $request->query->get('saison');
        if (!$this->isCsrfTokenValid('ENTRAINEMENT_DELETE',$token))
        {
            throw $this->createAccessDeniedException();
        }
        $em=$this->getDoctrine()->getManager();
        $em->remove($Entrainement);
        $em->flush();
        return $this->redirectToRoute('app_entrainement_entrainementlist',array("saison"=>$saison));
    }
}