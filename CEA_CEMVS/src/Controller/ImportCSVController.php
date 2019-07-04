<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\CsvImportType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ImportCSVController extends Controller
{
    /**
     * @Route("/Import", name="Import")
     */
    public function ImportCSVAction(UserPasswordEncoderInterface $encoder, Request $request){

        $form = $this->createForm(CsvImportType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()) {
            $fichier = $form['csv']->getData();
            $user_table = array(); // Stockage
            $line = 0;
            print_r($form['csv']->getData()->getpathName());
            if (($fichier = fopen($form['csv']->getData()->getpathName(), "r")) !== FALSE) {
                // Lecture, !! changer lien !!
                // Import CSV
                while (($data = fgetcsv($fichier, 1000, ";")) !== FALSE) {
                    // Séparateur ";"
                    $num = count($data); // Nombre par ligne traitée
                    $line++;
                    if ($line != 1) {
                        for ($c = 0; $c < $num; $c++) {
                            $user_table[$line - 1] = array(
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
                $password = $encoder->encodePassword($user, $user_unit["password"]);

                // Hydrate user
                //$user->setPassword($password);
                $user->setNom($user_unit["nom"]);
                $user->setPrenom($user_unit["prenom"]);
                $user->setLogin($user_unit["login"]);
                $user->setPassword($password);

                // Enregistrement du user en local
                $em->persist($user);

            }

            // Flush BDD
            $em->flush();
        }
    // Renvoi de la réponse
      return $this->render('csvImport/index.html.twig',[
          'form'=>$form->createView(),
      ]);


        /*return $this->render('security/connexion.html.twig',[
            'error'=> $utils->getLastAuthenticationError(),
            'last_username'=>$utils->getLastUsername(),
        ]);*/
    }
}