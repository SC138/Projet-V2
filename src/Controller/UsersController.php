<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsersController extends AbstractController
{
/**
* @Route("/profil-user", name="profil_user")
*/

    public function profil()
    {
        $user = $this->getUser();
        return $this->render('profil-user.html.twig', ['user' => $user]
        );
    }
    /**
     * @Route("/update-profil",name="update_profil")
     */
    public function updateProfile( HttpFoundation\Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository){
        $user= $this->getUser();
        $form= $this->createForm(UserType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
            $plainPassword=$form->get('password')->getData();
            $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success','profile updated');
        }
        return $this->render("update-profil.html.twig",['form'=>$form->createView(),'user'=>$user]);
        }
}