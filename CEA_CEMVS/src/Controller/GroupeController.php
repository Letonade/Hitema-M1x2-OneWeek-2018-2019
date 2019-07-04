<?php
namespace App\Controller;
use App\Entity\TireurGroupe;
use App\Entity\User;
use App\Form\TireurGroupeType;
use App\Repository\TireurGroupeRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/groupe")
 */
class GroupeController extends AbstractController
{
    /**
     * @Route("/", name="groupe_index", methods={"GET"})
     */
    public function index(TireurGroupeRepository $TireurGroupeRepository): Response
    {
        return $this->render('groupe/indexgroupe.html.twig', [
            'groupes' => $TireurGroupeRepository->findAll(),
        ]);
    }
    /**
     * @Route("/new", name="groupe_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $groupe = new TireurGroupe();
        $form = $this->createForm(TireurGroupeType::class, $groupe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tireurs = $groupe->getTireurs();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($groupe);
            foreach($tireurs as $tireur){
                $tireur->setGroupe($groupe);
            }
            $entityManager->persist($tireur);
            $entityManager->flush();
            return $this->redirectToRoute('groupe_index');
        }
        return $this->render('groupe/new.html.twig', [
            'groupe' => $groupe,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="groupe_show", methods={"GET"})
     */
    public function show(Groupe $groupe): Response
    {
        return $this->render('groupe/show.html.twig', [
            'groupe' => $groupe,
        ]);
    }
    /**
     * @Route("/{id}/edit", name="groupe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Groupe $groupe): Response
    {
        $form = $this->createForm(GroupeType::class, $groupe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tireurs = $groupe->getTireurs();
            foreach($tireurs as $tireur){
                $tireur->setGroupe($groupe);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tireur);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('groupe_index', [
                'id' => $groupe->getId(),
            ]);
        }
        return $this->render('groupe/edit.html.twig', [
            'groupe' => $groupe,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="groupe_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Groupe $groupe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$groupe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($groupe);
            $entityManager->flush();
        }
        return $this->redirectToRoute('groupe_index');
    }
}