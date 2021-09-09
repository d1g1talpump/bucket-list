<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route ("/", name="main_home")
     */
    function home(){
        return $this->render('main/home.html.twig');
    }

    /**
     * @Route ("/about", name="main_about")
     */
    function about(){
        return $this->render('main/about.html.twig');
    }
}
