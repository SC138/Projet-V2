<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @Route("/home-page", name="home-page")
     */

    public function homePage (){
        return $this->render('home-page.html.twig');

    }

}