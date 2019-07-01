<?php
/**
 * Created by PhpStorm.
 * User: arino
 * Date: 28/11/2018
 * Time: 11:15
 */

namespace App\Controller;



use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion")
     */
    public function connexion(AuthenticationUtils $utils){

        return $this->render('security/connexion.html.twig',[
            'error'=> $utils->getLastAuthenticationError(),
            'last_username'=>$utils->getLastUsername(),
        ]);
    }

    /**
     * @Route("/inscription")
     */
    public function inscription(Request $request)
    {
        $qcmPrime = new User();
        $form = $this->createForm(UserType::class, $qcmPrime);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($qcmPrime);
            $em->flush();
            return $this->redirectToRoute('index');
        }

        return $this->render('security/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/", name="index")
     */

    public function indexAction(Request $request)
    {

        return $this->render('index.html.twig');
    }
}