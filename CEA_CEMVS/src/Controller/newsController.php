<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Entrainement;
use App\Entity\Competition;

class newsController extends AbstractController
{
    /**
     * @Route("/", name="news")
     */
    public function index(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $EntrainementRepository     = $em->getRepository(Entrainement::class);
        $CompetitionRepository     = $em->getRepository(Competition::class);

		$dateNow 		= new \DateTime();
		$date7 			= new \DateTime();
		$date7->add(new \DateInterval('P10D'));
        $Entrainements 	= $EntrainementRepository->getMyEntrainementByDate($dateNow, $date7);
        $Competitions 	= $CompetitionRepository->getMyCompetitionByDate($dateNow, $date7);

        return $this->render('news/index.html.twig', [
            'Entrainements' => $Entrainements,
            'Competitions' => $Competitions,
        ]);
    }
}
