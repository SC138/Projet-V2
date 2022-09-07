<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class, ['attr'=>['class'=>'form-control']])
            ->add('password', RepeatedType::class, [
                'options'=>['attr'=>['class'=>'form-control']],
                'type' => PasswordType::class,
                'invalid_message' => 'Mot de passe invalide',
                'first_options' => ['label' => 'Nouveau mot de passe'],
                'second_options' => ['label' => 'Confirmer mot de passe'],
                //POUR LE CSS: pour ajouter une classe sur un champ FORM: 'attr' => ['class' => 'nom de ma classe']
//                'second_option' => ['label' => 'Confirmer le mot de passe'],

            ])
            ->add('Modifier',SubmitType::class, ['attr'=>['class'=>'form-control my-4']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
