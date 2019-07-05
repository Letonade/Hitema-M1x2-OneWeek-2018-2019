<?php
namespace App\Controller;

use App\Entity\Competition;
use App\Entity\CompetitionCompetiteur;
use App\Entity\User;
use App\Form\AddCompititeurCompetitionType;
use App\Form\AddEncadrantCompetitionType;
use App\Form\CompetitionType;
use App\Form\DateCalendarCompetitionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompetitionController extends Controller
{
    /**
     * @Route("/CompetitionsAdd/{saison}")
     */
    public function CompetitionAdd(Request $request, $saison){
    	$Competitions 	= new Competition();
        $form 			= $this->createForm(CompetitionType::class, $Competitions, array("saison" => $saison));
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()) {
            $em=$this->getDoctrine()->getManager();

        	$form_competition = $request->request->get("competition");

            $nom = $form_competition["nom"];

            foreach ($form_competition as $key => $value) {
                $tmp = explode("_", $key);
                if($tmp[0]=="Date"){
                    $day = substr("00".$tmp[1], (strlen($tmp[1])), 2);
                    $month = $tmp[2];
                    $year = $tmp[3];
                    //variable pour bdd
                    $date_time_deb = new \DateTime($day."-".$month."-".$year." ".$form_competition["HeureDebut"].":00", new \DateTimeZone("Europe/Paris"));
                    $date_time_fin = new \DateTime($day."-".$month."-".$year." ".$form_competition["HeureFin"].":00", new \DateTimeZone("Europe/Paris"));
                    
                    $new_competition = new Competition();
                    $new_competition->setDateDebut($date_time_deb);
                    $new_competition->setDateFin($date_time_fin);
                    $new_competition->setNom($nom);
                    $em->persist($new_competition);
                    //print_r($day."/".$month."/".$year." ".$form_competition["HeureDebut"].":00");

                }
            }
            $em->flush();
        }

        return $this->render('competition/competitionAdd.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/DateCalendarCompetitions")
     */
    public function DateCalendarCompetition(Request $request){
        $form = $this->createForm(DateCalendarCompetitionType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()) {
            if ($form->get('Ajout')->isClicked()){
                return $this->redirectToRoute('app_competition_competitionadd',array(
                    "saison" => $request->request->get("date_calendar_competition","Saison")["Saison"],
                ));
            }elseif ($form->get('Visuel')->isClicked()){
                return $this->redirectToRoute('app_competition_competitionlist',array(
                    "saison" => $request->request->get("date_calendar_competition","Saison")["Saison"],
                ));
            }
        }

        return $this->render('competition/DateCalendarCompetition.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/Competitions/{saison}")
     */
    public function CompetitionList(Request $request, $saison){
        $em=$this->getDoctrine()->getManager();
        $CompetitionRepository     = $em->getRepository(Competition::class);
        $Competitions              = $CompetitionRepository->findAll();

        return $this->render('competition/competitionListe.html.twig', [
            'Competitions' => $Competitions,
            'saison' => $saison,
        ]);
    }

    /**
     * @Route("/Competitions/{id}/supprimer", requirements={"id":"\d+"}, name="deleteCompetition")
     */
    public function deleteCompetitionAction(Competition $Competition,Request $request)
    {
        $token = $request->query->get('token');
        $saison = $request->query->get('saison');
        if (!$this->isCsrfTokenValid('COMPETITION_DELETE',$token))
        {
            throw $this->createAccessDeniedException();
        }
        $em=$this->getDoctrine()->getManager();
        $em->remove($Competition);
        $em->flush();
        return $this->redirectToRoute('app_competition_competitionlist',array("saison"=>$saison));
    }

    /**
     * @Route("/Competition/{id}")
     */
    public function CompetitionView(Request $request,Competition $competition){

        $competiteurs = $competition->getCompetiteurCompetitions();
        $encadrants = $competition->getEncadrants();
        $saison = $request->query->get('saison');
        return $this->render('competition/competitionVue.html.twig', [
            'Competition' => $competition,
            'competiteurs' => $competiteurs,
            'encadrants' => $encadrants,
            "saison"=>$saison,
        ]);
    }

    /**
     * @Route("/Competition/{id}/sinscrirerT", requirements={"id":"\d+"}, name="sinsrireCompetitionT")
     */
    public function sinscrireTCompetitionAction(Competition $competition,Request $request)
    {
        $token = $request->query->get('token');
        $saison = $request->query->get('saison');
        if (!$this->isCsrfTokenValid('COMPETITION_SINSCRIRET',$token))
        {
            throw $this->createAccessDeniedException();
        }
        $em=$this->getDoctrine()->getManager();
        $competitionCompetiteur = new CompetitionCompetiteur();
        $competitionCompetiteur->setProfil($this->getUser());
        $competitionCompetiteur->setCompetition($competition);
        $em->persist($competitionCompetiteur);
        $em->flush();
        return $this->redirectToRoute('app_competition_competitionlist',array("saison"=>$saison));
    }

    /**
     * @Route("/Competition/{id}/sinscrirerM", requirements={"id":"\d+"}, name="sinsrireCompetitionM")
     */
    public function sinscrireMCompetitionAction(Competition $competition,Request $request)
    {
        $token = $request->query->get('token');
        $saison = $request->query->get('saison');
        if (!$this->isCsrfTokenValid('COMPETITION_SINSCRIREM',$token))
        {
            throw $this->createAccessDeniedException();
        }
        $em=$this->getDoctrine()->getManager();
        $competition->addEncadrant($this->getUser());
        $em->persist($competition);
        $em->flush();
        return $this->redirectToRoute('app_competition_competitionlist',array("saison"=>$saison));
    }

    /**
     * @Route("/Competition/{id}/addC", name="addCompetiteurCompetition")
     */
    public function addCompetiteurCompetitionView(Request $request,Competition $competition){

        $form 			= $this->createForm(AddCompititeurCompetitionType::class);
        $form->handleRequest($request);
        $saison = $request->query->get('saison');
        if ($form->isSubmitted()&&$form->isValid()) {
            // print_r("good t");
            $em=$this->getDoctrine()->getManager();
            $userRepository = $em->getRepository(User::class);
            foreach ($request->request->get("add_compititeur_competition")["Tireurs"] as $tireurId)
            {
                //print_r($tireurId);
                $tireur = $userRepository->findOneBy(['id'=>$tireurId]);
                $competitionCompetiteur = new CompetitionCompetiteur();
                $competitionCompetiteur->setCompetition($competition);
                $competitionCompetiteur->setProfil($tireur);
                $tireur->addCompetiteurCompetition($competitionCompetiteur);
                $competition->addCompetitionCompetiteur($competitionCompetiteur);
                $em->persist($tireur);
                $em->persist($competition);
                $em->persist($competitionCompetiteur);

            }
            $em->flush();
            return $this->redirectToRoute('app_competition_competitionview',array("id"=>$competition->getId(),"saison"=>$saison));
        }


        return $this->render('entrainement/entrainementVueAddT.html.twig', [
            'competition' => $competition,
            'form' => $form->createView(),
            'saison' => $saison,
        ]);
    }

    /**
     * @Route("/Competition/{id}/supprimerC", requirements={"id":"\d+"}, name="deleteCompetitionC")
     */
    public function deleteEntrainementTireurAction(CompetitionCompetiteur $competitionCompetiteur,Request $request)
    {
        $token = $request->query->get('token');
        $saison = $request->query->get('saison');
        if (!$this->isCsrfTokenValid('COMPETITION_DELETEC',$token))
        {
            throw $this->createAccessDeniedException();
        }
        $em=$this->getDoctrine()->getManager();
        $ide = $competitionCompetiteur->getCompetition()->getId();
        $em->remove($competitionCompetiteur);
        $em->flush();
        return $this->redirectToRoute('app_competition_competitionview',array("id"=>$ide,"saison"=>$saison));
    }

    /**
     * @Route("/Competition/{id}/addE", name="addEncadrantCompetition")
     */
    public function addEncadrantCompetitionView(Request $request,Competition $competition){

        $form 			= $this->createForm(AddEncadrantCompetitionType::class);
        $saison = $request->query->get('saison');
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()) {
            //print_r("good m");
            $em=$this->getDoctrine()->getManager();
            $userRepository = $em->getRepository(User::class);
            foreach ($request->request->get("add_encadrant_competition")["MAs"] as $tireurId)
            {
                //print_r($tireurId);
                $ma = $userRepository->findOneBy(['id'=>$tireurId]);
                $competition->addEncadrant($ma);
                $em->persist($competition);
                $em->flush();
                return $this->redirectToRoute('app_competition_competitionview',array("id"=>$competition->getId(),"saison"=>$saison));
            }
        }


        return $this->render('entrainement/entrainementVueAddM.html.twig', [
            'competition' => $competition,
            'form' => $form->createView(),
            'saison' => $saison,
        ]);
    }

    /**
     * @Route("/Competition/{id}/supprimerM", requirements={"id":"\d+"}, name="deleteCompetitionM")
     */
    public function deleteEntrainementMaAction(User $user,Request $request)
    {
        $token = $request->query->get('token');
        $saison = $request->query->get('saison');
        $ide = $request->query->get('ide');
        if (!$this->isCsrfTokenValid('COMPETITION_DELETEM',$token))
        {
            throw $this->createAccessDeniedException();
        }
        $em=$this->getDoctrine()->getManager();
        $entrainementRepository = $em->getRepository(Competition::class);
        $ent = $entrainementRepository->findOneBy(['id'=>$ide]);
        $user->removeEncadrantCompetition($ent);
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('app_competition_competitionview',array("id"=>$ide,"saison"=>$saison));
    }

}