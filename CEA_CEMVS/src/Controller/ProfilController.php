<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends Controller
{
    /**
     * @Route("/Profils/{type}")
     */
    public function ProfilsList(Request $request, $type){
        $em=$this->getDoctrine()->getManager();
        $ProfilsRepository      = $em->getRepository(User::class);
        $Profils                = $ProfilsRepository->findAll();

        return $this->render('profil/profilListe.html.twig', [
            'Profils' => $Profils,
            'type' => $type,
        ]);
    }
    
    /**
     * @Route("/Profils/{type}")
     */
    public function ProfilsList(Request $request, $type){
        $em=$this->getDoctrine()->getManager();
        $ProfilsRepository      = $em->getRepository(User::class);
        $Profils                = $ProfilsRepository->findAll();

        return $this->render('profil/profilListe.html.twig', [
            'Profils' => $Profils,
            'type' => $type,
        ]);
    }
}