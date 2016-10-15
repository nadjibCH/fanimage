<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use Doctrine\DBAL\Driver\PDOConnection;
use Doctrine\DBAL\Driver\PDOException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \PDO;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;




class FormController extends Controller
{
    /**
     * @Route("/edit")
     */
    public function editAction(Request $request)
    {

        $photourlimage=$photonom=$nomimage= $description = $blobimage= $tailleimage = $typeimage = null;
        $form = $this->createFormBuilder() // création de formulaire et on ajoute les composants avec ->add
            ->add('description', TextType::class)
            ->add('image', FileType::class )
            ->add('save', SubmitType::class, array('label' => 'Save image'))
            ->getForm();

        $form->handleRequest($request); //********** permet de recuperer les infos une fois le formulaire validé

        if($form->isValid())
        {
            $blobimage=$form["image"]->getData(); // avoir les details de l'image (taille, nom, extension type ...)
            //**********pour acceder a tous les details d'une image YESSSSSSSSSSSSSSSSSSSSSSss************************
            //"getATime", "getBasename", "getCTime", "getClientMimeType", "getClientOriginalExtension",
            // "getClientOriginalName","getClientSize","getError", "getErrorMessage", "getExtension",
            // "getFileInfo", "getFilename", "getGroup", "getInode",getLinkTarget", "getMTime","getMaxFilesize",
            // "getMimeType", "getOwner", "getPath", "getPathInfo", "getPathname","getPerms", "getRealPath", "getSize" or "getType"?

            $tblext=['jpg', 'png', 'jpeg', 'gif'];
            //var_dump($tblext); die;
            if (in_array($ext=strtolower($blobimage->getClientOriginalExtension()), $tblext))
            {

                $description=strtolower($form["description"]->getData()); // recuperer le champs description


                $path= $blobimage->getPathname(); // avoir le path temporaire de l'image; c'est la ou l'image est stoqué temporairement
                $nomimage=strtolower($blobimage->getClientOriginalName()); // avoir le nom origine de l'image

/*
                header ('Content-Type: image/png');
                $im = imagecreate(120, 20) // créer une image avec largeur et hauteur en pixel
                or die('Impossible de crée un flux d\'image GD');


                $text_color = imagecolorallocate($im, 233, 14, 91);
                imagestring($im, 1, 5, 5,  'Une simple chaîne de texte', $text_color);
                imagepng($im);
                var_dump(imagepng($im));
                imagedestroy($im);


// Calcul des nouvelles dimensions
                list($width, $height) = getimagesize($path);
                $new_width = $width * 0.5;
                $new_height = $height * 0.5;

// Redimensionnement
                $image_p = imagecreatetruecolor($new_width, $new_height);

                $image = imagecreatefromjpeg($path);

                var_dump($image); die;
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

// Affichage
                $toto=imagejpeg($image_p, null, 100);
var_dump($toto); die;*/

                $urlimage="C:\\wamp\\www\\faniemage\\web\\bundles\\framework\\images"."\\".$nomimage ;
                move_uploaded_file($path, $urlimage ); //deplacer l'image dans un dossier precis et lui donner le meme nom initial
//var_dump($urlimage);die;

                //header ("Content-type: image/png");
                //$image = imagecreatefrompng($urlimage);
                //var_dump($image); die;


                $temps=time();//avoir l'heure et la date de l'ajoute de la photo en milisecondes
                $date_enreg=date('Y-m-d H:i:s',$temps);//avoir le bon format de l'heure et la date

                $tailleimage=$blobimage->getClientSize(); // la taille de l'image
                $typeimage=strtolower($blobimage->getClientOriginalExtension()); //l'extension de l'image


                $blob=$this->affiche();
                $this->save($nomimage, $description,$urlimage, $tailleimage,$typeimage,$date_enreg);

                $photonom=$blob['photonom'];
                $photourlimage=$blob['photourlimage'];
            }else{
                echo "Le fichier chargé n'est pas une image";
            }

        }

        return $this->render('AppBundle:Form:form.html.twig', array(
            'ismi' => 'nadjib',
            'form' => $form->createView(),
            'nomimage' => $photonom,
            'blob' => $photourlimage
        ));
    }


    public function save($nomimage, $description,$urlimage, $tailleimage,$typeimage,$date_enreg){

        $db=$this->connexion();
        $stmt=$db->prepare("INSERT INTO tblphoto (photonom, photodescripetion, photourlimage, phototaille, phototype, photodateenreg)
                                VALUES (:photonom, :description, :urlimage, :tailleimage, :typeimage, :dateenreg)");

        $stmt->bindParam(':photonom', $nomimage, PDO::PARAM_STR);
        $stmt->bindParam(':urlimage', $urlimage, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);

        $stmt->bindParam(':tailleimage', $tailleimage, PDO::PARAM_INT);
        $stmt->bindParam(':typeimage', $typeimage);
        $stmt->bindParam(':dateenreg', $date_enreg);

        $stmt->execute(); //exécuter une requete préparée

        echo("New image saved successfully");
    }

    public function affiche(){
        $db=$this->connexion();
        $stmt=$db->prepare("select * from tblphoto ORDER BY idphoto DESC LIMIT 0, 1");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //var_dump ($row); die;
        return  $row;
        //return $row['blobimage'];

    }

    function connexion (){
        try {
            $host_name=$this->container->getParameter('database_host_name');
            $user=$this->container->getParameter('database_user');
            $password=$this->container->getParameter('database_password');

            $db= new \PDO($host_name,$user,$password);
            return $db;
        }catch (PDOException $e){
            echo $e->getMessage();
            die;
        }

    }

}
