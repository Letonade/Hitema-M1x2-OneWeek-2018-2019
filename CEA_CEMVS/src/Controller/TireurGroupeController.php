<?php

namespace App\Controller;

use App\Entity\TireurGroupe;
use App\Form\TireurGroupeType;
use App\Repository\TireurGroupeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/Tireurgroupe")
 */
class TireurGroupeController extends AbstractController
{
    /**
     * @Route("/", name="groupeIndex", methods={"GET"})
     */
    public function index(TireurGroupeRepository $TireurGroupeRepository): Response
    {
        return $this->render('groupe/indexgroupe.html.twig', [
            'groupes' => $TireurGroupeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/newGroupe", name="newGroupe", methods={"GET","POST"})
     */
    public function newGroupe(Request $request): Response
    {
        $groupe = new TireurGroupe();
        $form = $this->createForm(TireurGroupeType::class, $groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($groupe);
            $entityManager->flush();

            return $this->redirectToRoute('groupeIndex');
        }

        return $this->render('groupe/newGroupe.html.twig', [
            'groupe' => $groupe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="groupeShow", methods={"GET"})
     */
    public function show(TireurGroupe $groupe): Response
    {
        return $this->render('groupe/showgroupe.html.twig', [
            'groupe' => $groupe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="groupeEdit", methods={"GET","POST"})
     */
    public function edit(Request $request, TireurGroupe $groupe): Response
    {
        $form = $this->createForm(TireurGroupeType::class, $groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('groupeIndex', [
                'id' => $groupe->getId(),
            ]);
        }

        return $this->render('groupe/edit.html.twig', [
            'groupe' => $groupe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="groupeDelete", methods={"DELETE"})
     */
    public function delete(Request $request, TireurGroupe $groupe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$groupe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($groupe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('groupeIndex');
    }
}
