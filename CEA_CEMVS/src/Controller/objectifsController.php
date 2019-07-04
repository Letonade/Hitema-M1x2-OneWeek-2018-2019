<?php
namespace App\Controller;
use App\Entity\Objectif;
use App\Form\ObjectifType;
use App\Repository\ObjectifRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("objectifs")
 */
class objectifsController extends AbstractController
{
    /**
     * @Route("/", name="objectifs_index", methods={"GET"})
     */
    public function index(ObjectifRepository $ObjectifRepository)
    {
        return $this->render('objectifs/index.html.twig', [
            'objectifs' => $ObjectifRepository->findAll(),
        ]);
    }
    /**
     * @Route("/new", name="objectifs_new", methods={"GET","POST"})
     */
    public function new(Request $request)
    {
        $Objectif = new Objectif();
        $form = $this->createForm(ObjectifType::class, $Objectif);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Objectif);
            $entityManager->flush();
            return $this->redirectToRoute('objectifs_index');
        }
        return $this->render('objectifs/new.html.twig', [
            'Descriptif' => $Objectif,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="objectifs_show", methods={"GET"})
     */
    public function show(Objectif $Objectif): Response
    {
        return $this->render('objectifs/show.html.twig', [
            'objectif' => $Objectif,
        ]);
    }
    /**
     * @Route("/{id}/edit", name="objectifs_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Objectif $Objectif)
    {
        $form = $this->createForm(ObjectifsType::class, $Objectif);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('objectifs_index', [
                'id' => $Objectif->getId(),
            ]);
        }
        return $this->render('objectifs/edit.html.twig', [
            'objectif' => $Objectif,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="objectifs_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Objectif $Objectif)
    {
        if ($this->isCsrfTokenValid('delete'.$Objectif->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($Objectif);
            $entityManager->flush();
        }
        return $this->redirectToRoute('objectifs_index');
    }
}