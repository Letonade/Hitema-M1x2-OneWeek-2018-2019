<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class newsController extends AbstractController
{
    /**
     * @Route("/", name="news")
     */
    public function index(Request $request)
    {
        
        return $this->render('news/index.html.twig');
    }
}
