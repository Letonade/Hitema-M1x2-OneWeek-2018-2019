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
     * @Route("/Profils")
     */
    public function ProfilsList(Request $request){
        $em=$this->getDoctrine()->getManager();
        $ProfilsRepository      = $em->getRepository(User::class);
        $Profils                = $ProfilsRepository->findAll();

        return $this->render('profil/profilListe.html.twig', [
            'Profils' => $Profils,
        ]);
    }

    /**
     * @Route("/Profil/{id}")
     */
    public function ProfilsVue(Request $request, User $profil){

        return $this->render('profil/profilVue.html.twig', [
            'Profil' => $profil,
        ]);
    }
}