<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/admin/admins" , name="admin_list_admins")
     */

    public function listAdmin(UserRepository $userRepository): Response
    {
        $admins=$userRepository->findAll(); //je cherche tout les users de la BDD
        return $this->render('Admin/admin_list_admins.html.twig',[
            'admins'=> $admins]);// j'affiche les admins
    }


    /**
     * @Route("/admin-register", name="register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        // On déclare créer une nouvelle entrée dans la table user
        $user = new User();
        // On utilise le setter pour attribuer le rôle admin à notre nouvelle entrée
        $user->setRoles(["ROLE_ADMIN"]);

        //creatiopn du formulaire d'après le gabarit UserType (UserType créé avec le terminal make form)
        $form = $this->createForm(RegistrationFormType::class, $user);
        // handleRequest, permis par l'instance de la classe Request: Permet de récuperer dans une variable $form,
        // les valeurs entrée dans les champs du formulaire
        $form->handleRequest($request);

        // Condition qui permet de savoir j'ai bien soumis les champs à mon formulaire et qu'ils sont valide
        if ($form->isSubmitted() && $form->isValid()) {

            // récuparation des données dans le champ "password" pour les stocker dans la variable $plainPassword
            $plainPassword = $form->get('password')->getData();
            // En utilisant la fonction hashPassword permise par l'intance de classe $userPasswordHasher
            // on crypte le MDP contenu dans $plainPassword qu'on vient ensuite stocker dans une variable $hashedPassword
            $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);

            // On utilise le setter de $user pour définir le MDP en utilsant celui
            // qui est contenu dans dans $hashedPassword
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            // On enregister et on fais l'inscription en BDD
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('home-page');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }


        /**
     * @Route("/admin/admin_update/{id}", name="admin_admin_update")
     */
        public function updateAdmin($id, UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher):Response
        {

            $user = $userRepository->find($id);

            $form = $this->createForm(RegistrationFormType::class, $user);

            $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
//            $userRepository->add($user, true);
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

    public function deleteAdmin($id, UserRepository $userRepository, EntityManagerInterface $entityManager):Response
    {
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


//    /**
//     * @Route("/admin/admin_update/{id}", name="admin_admin_update")
//     */
//    public function updateAdmin($id, UserRepository $userRepository, EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
//    {
//        $user = $userRepository->find($id);
//
//        $form = $this->createForm(UserType::class, $user);
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $plainPassword = $form->get('password')->getData();
//            $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);
//            $user->setPassword($hashedPassword);
//
//            $entityManager->persist($user);
//            $entityManager->flush();
//
//            $this->addFlash("success", " Admin modifié ! ");
//        }
//
//        return $this->render("admin/update_admin.html.twig", [
//            "form" => $form->createView()
//        ]);
//    }
}

