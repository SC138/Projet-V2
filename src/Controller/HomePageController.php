<?php

namespace App\Controller;

use App\Repository\PicturesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @Route("/home-page", name="home-page")
     */

    public function homePage (PicturesRepository $picturesRepository){

        $pictures = $picturesRepository->findBy([], ['id' => 'DESC'],3);
        return $this->render('home-page.html.twig', ['pictures'=> $pictures]);

    }

}