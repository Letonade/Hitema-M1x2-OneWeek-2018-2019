<?php
namespace App\Controller;
use App\Entity\Lecon;
use App\Entity\Entrainement;
use App\Entity\EntrainementTireur;
use App\Form\LeconType;
use App\Repository\LeconRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/lecon")
 */
class LeconController extends AbstractController
{
    /**
     * @Route("/",name ="lecon_index", methods={"GET"})
     */
    public function index(LeconRepository $leconRepository): Response
    {
     
        return $this->render('lecon/index.html.twig', [
            'lecons' =>$leconRepository->findAll(),
        ]);
            
        }
        /**
         * @Route("/{idEntrainement}/new", methods={"GET","POST"})
         * @ParamConverter("entrainement", options={"id" = "idEntrainement"})
         */
  
        public function new(Request $request, Entrainement $entrainement): Response
    {
        $lecon = new Lecon();
        $lecon->setEntrainement($entrainement);
        if ($this->getUser()->getRole()=== 2) {
            $lecon->setMa($this->getUser());
        } else if ($this->getUser()->getRole() === 1) {
            $lecon->setTireur($this->getUser());
        }
        $form = $this->createForm(LeconType::class, $lecon);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lecon);
            $entityManager->flush();
            return $this->redirectToRoute('app_lecon_index');
        }
        return $this->render('lecon/new.html.twig', [
            'lecon' => $lecon,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function show(Lecon $lecon)
    {
        return $this->render('lecon/show.html.twig', [
            'lecon' => $lecon,
        ]);
    }
    /**
     * @Route("/{id}/edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Lecon $lecon): Response
    {
        $form = $this->createForm(LeconType::class, $lecon1);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commentaireMaitre = $lecon->getTexteMaitre();
            $commentaireTireur = $lecon->getTexteTireur();       
            $entityManager = $this->getDoctrine()->getManager();
            foreach ($commentaireMaitre as $lecon) {
                $commentaireMaitre->setLecon($lecon1);
                $entityManager->persist($commentaireMaitre);
            }
            foreach ($commentaireTireur as $lecon) {
                $commentaireTireur->setLecon($lecon1);
                $entityManager->persist($commentaireTireur);
            }
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('app_lecon_index', [
                'id' => $lecon->getId(),
            ]);
        }
        return $this->render('lecon/edit.html.twig', [
            'lecon' => $lecon,
            'form' => $form->createView(),
        ]);
    }
  
}