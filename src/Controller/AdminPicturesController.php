<?php

namespace App\Controller;

use App\Entity\Pictures;
use App\Form\PictureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminPicturesController extends AbstractController
{
    /**
     * @Route("/admin-pictures", name="admin_pictures")
     */

    public function insertPicture(EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger){

        $picture = new Pictures();

        $form = $this->createForm(PictureType::class, $picture);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $pictures = $form->get('picture')->getData();

            $originalFilename = pathinfo($pictures->getclientOriginalName(), PATHINFO_FILENAME);

            $safeFilename = $slugger->slug($originalFilename);

            $newFilename = $safeFilename."-".uniqid().'.'.$pictures->guessExtension();

            $pictures->move($this->getParameter('image_directory'), $newFilename);

            $pictures->setImage($newFilename);

            $entityManager->persist($pictures);
            $entityManager->flush();

            $this->addFlash('success', 'Photo Publiée');
        }

        return $this->render("admin/pictures.html.twig", ['form' => $form->createView()]);
    }

}