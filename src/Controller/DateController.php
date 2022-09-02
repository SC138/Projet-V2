<?php

namespace App\Controller;
use App\Entity\DateUser;
use App\Entity\User;
use App\Form\DateUserType;
use App\Repository\DateUserRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class DateController extends AbstractController
{
    /**
     * @Route ("/date-user", name="date_user")
     */

    public function dateUser( DateUserRepository $dateUserRepository,User $user,UserRepository $userRepository,Request $request, EntityManagerInterface $entityManager){


        $dateUser = new DateUser();
        $user->setUser($this->getUser());
        $form = $this->createForm(DateUserType::class, $dateUser);
        $form->handleRequest($request);


        if( $form->isSubmitted() && $form->isValid()){
            $entityManager->persist($dateUser);
            $entityManager->flush();
        }

        return $this->render('date-user.html.twig', [
            'form'=> $form -> createView()
        ]);

    }

}