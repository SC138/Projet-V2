<?php

namespace App\Controller;

use App\Repository\PicturesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{
    /**
     * @Route("/gallery", name="gallery")
     */

    public function gallery (PicturesRepository $picturesRepository){

        $pictures = $picturesRepository->findBy([], ['id' => 'DESC']);

        return $this->render('gallery.html.twig', ['pictures'=> $pictures]);
    }
}