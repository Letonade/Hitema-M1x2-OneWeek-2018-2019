<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class bodyController extends AbstractController
{
    /**
     * @Route("/", name="body")
     */
    public function index(Request $request)
    {
        
        return $this->render('body/index.html.twig');
    }
}
