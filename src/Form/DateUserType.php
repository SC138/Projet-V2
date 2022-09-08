<?php

namespace App\Form;

use App\Entity\DateUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DateMeet',DateTimeType::class, [
                'label'=>'Date de Rendez Vous',
                'label_attr' => ['class' => 'rdv'],

            ])
            ->add('Envoyer', SubmitType::class, ['attr'=>['class'=>'form-control my-4']]);
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DateUser::class,
        ]);
    }
}
