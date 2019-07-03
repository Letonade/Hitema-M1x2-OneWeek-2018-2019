<?php
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
    public function connexion(AuthenticationUtils $authentificationUtils)
    {
        $lastUsername = $authentificationUtils->getLastUsername();
        $error = $authentificationUtils->getLastAuthenticationError();
        
        return $this->render('security/connexion.html.twig', [
            'controller_name' => 'SecurityController',
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
     /**
     * @Route("/inscription",name ="inscription")
     */
    public function inscription(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('news');
        }
        return $this->render('security/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}