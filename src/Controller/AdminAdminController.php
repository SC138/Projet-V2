<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     * @Route ("/admin/update", name="admin_update")
     */

    public function updateAdmin(UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager, User $user, UserPasswordHasherInterface $userPasswordHasher){

        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $userRepository->add($user, true);
            $plainPassword = $form->get('password')->getData();
            $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Mot de passe modifié');

            return $this ->redirectToRoute("home-page");
        }

        return $this->renderForm('admin/update_admin.html.twig', [
            'user'=> $user,
            'form'=> $form,
        ]);
    }

    /**
     * @Route ("admin/delete/admin/{id}", name="admin_delete_admin")
     */

    public function deleteAdmin($id, UserRepository $userRepository, EntityManagerInterface $entityManager){
        $user = $userRepository->find($id);
        if (!is_null($user)){
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success', 'Le compte est bien supprimé');
            return $this->redirectToRoute("home-page");
        } else {
            return new Response('Compte introuvable');
        }
    }
}