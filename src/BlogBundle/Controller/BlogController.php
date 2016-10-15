<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    /**
     * @Route("/blog")
     */
    public function BlogAction()
    {
        $content= $this->render('BlogBundle:Blog:blog.html.twig', array(
            'nom' => 'djibou'

        ));
        return new Response($content);
    }
}
