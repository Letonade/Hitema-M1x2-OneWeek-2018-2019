<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportCSVController extends Controller
{
    /**
     * @Route("/Import")
     */
    public function ImportCSVAction(){

        $user_table = array(); // Stockage
        $line = 0;
        // Import CSV 
        if (($fichier = fopen(__DIR__ . "/../../../TEST_IMPORT_TIREUR.csv", "r")) !== FALSE) { 
        // Lecture, !! changer lien !!
            while (($data = fgetcsv($fichier, 1000, ";")) !== FALSE) { 
            // Séparateur ";"
                $num = count($data); // Nombre par ligne traitée
                $line++;
                if ($line != 1) {
                    for ($c = 0; $c < $num; $c++) {
                        $user_table[$line-1] = array(
                                "nom" => $data[0],
                                "prenom" => $data[1],
                                "login" => $data[2],
                                "password" => $data[3]
                        );
                    }
                }
            }
            // foreach ($user_table as $user_unit) {
            //     print_r($user_unit);
            //     print_r("<br>");
            // }//Vision sur la data
            fclose($fichier); 
        }

        $em = $this->getDoctrine()->getManager(); // EntityManager pour la base de données
        
        // Lecture de user_table et comm bdd
        foreach ($user_table as $user_unit) {
            
            // On crée un user
            $user = new User();
            // Encode le mdp TEST trouvé sur le net
            // $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
            // $plainpassword = $user_unit["password"];
            // $password = $encoder->encodePassword($plainpassword, $user->getSalt());

            // Hydrate user
            //$user->setPassword($password);
            $user->setNom($user_unit["nom"]);
            $user->setPrenom($user_unit["prenom"]);
            $user->setLogin($user_unit["login"]);
            $user->setPassword($user_unit["password"]);
                
            // Enregistrement du user en local
            $em->persist($user);
            
        }
        
        // Flush BDD
        $em->flush();

        // Renvoi de la réponse
        return new Response('Done !');

        /*return $this->render('security/connexion.html.twig',[
            'error'=> $utils->getLastAuthenticationError(),
            'last_username'=>$utils->getLastUsername(),
        ]);*/
    }
}