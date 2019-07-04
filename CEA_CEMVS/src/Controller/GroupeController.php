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
    public function new(Request $request)
    { 
        $groupe = new TireurGroupe();
        $form = $this->createForm(TireurGroupeType::class, $groupe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($groupe);
            $entityManager->flush();
            return $this->redirectToRoute('groupe_index');
        }
        return $this->render('groupe/newGroupe.html.twig', [
            'TireurGroupe' => $groupe,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="groupe_show", methods={"GET"})
     */
    public function show(TireurGroupe $groupe)
    {
        return $this->render('groupe/showgroupe.html.twig', [
            'TireurGroupe' => $groupe,
        ]);
    }
    /**
     * @Route("/{id}/edit", name="groupe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TireurGroupe $groupe): Response
    {
        $form = $this->createForm(TireurGroupeType::class, $groupe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('groupe_index', [
                'id' => $groupe->getId(),
            ]);
        }
        return $this->render('groupe/editgroupe.html.twig', [
            'groupe' => $groupe,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="groupe_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TireurGroupe $groupe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$groupe-> getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($groupe);
            $entityManager->flush();
        }
        return $this->redirectToRoute('groupe_index');
    }
}