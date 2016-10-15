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




class HomeController extends Controller
{
    /**
     * @Route("/home")
     */
    public function homeAction(Request $request)
    {

        $tblimage=$this->affiche();

        return $this->render('AppBundle:Home:home.html.twig', array(
            'ismi' => 'nadjib',
            'tblimage' =>$tblimage
        ));
    }


    public function affiche(){
        $db=$this->connexion();
        $stmt=$db->prepare("select * from tblphoto ORDER BY idphoto DESC ");
        $stmt->execute();

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
