<?php

namespace App\Controller;

use App\Entity\Pictures;
use App\Form\PictureType;
use App\Repository\PicturesRepository;
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

    public function insertPicture(PicturesRepository $picturesRepository, EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger){

        $pictures = new Pictures();

        $form = $this->createForm(PictureType::class, $pictures);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $image = $form->get('image')->getData();

            $originalFilename = pathinfo($image->getclientOriginalName(), PATHINFO_FILENAME);

            $safeFilename = $slugger->slug($originalFilename);

            $newFilename = $safeFilename."-".uniqid().'.'.$image->guessExtension();

            $image->move(
                $this->getParameter('images_directory'),
                $newFilename
            );

            //$image->setPicture($newFilename);
            $pictures->setPicture($newFilename);
            //$picturesRepository->add($pictures, true);
            $entityManager->persist($pictures);
            $entityManager->flush();

            $this->addFlash('success', 'Photo Publiée');
        }

        return $this->render("admin/pictures.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @Route("/admin-pictures-delete/{id}",  name="admin_pictures_delete")
     */

    public function deletePicture($id,PicturesRepository $picturesRepository, EntityManagerInterface $entityManager){
        $pictures = $picturesRepository->find($id);

        if (!is_null($pictures)){
            $entityManager->remove($pictures);
            $entityManager->flush();

            $this->addFlash('success', 'Photo supprimée');
        }
        return $this->redirectToRoute('home-page');

    }

}