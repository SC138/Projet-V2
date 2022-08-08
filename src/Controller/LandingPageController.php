<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LandingPageController extends AbstractController
{
    //La Route permet de générer le nom de l'url
    /**
     * @Route("/", name="landing")
     */

    //La méthode ("function") appel le fichier twig avec la méthode render. render prend le fichier twig et le transforme en HTML
    // le return permet de le renvoyer au naviogateyr
    public function landingPage() {
        return $this->render('landing-page.html.twig');
    }

}
