<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAdminController extends AbstractController
{
    /**
     * @Route ("/admin/create", name="admin_create")
     */

    public function createAdmin(UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher){
        $user = new User();

        $user->setRoles(["ROLE_ADMIN"]);

        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $plainPassword = $form->get('password')->getData();

            $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);

            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Mot de passe créé');

            return $this ->redirectToRoute("home-page");
        }

        return $this->render('admin/create.html.twig', ['form' =>$form->createView()
        ]);

    }

}