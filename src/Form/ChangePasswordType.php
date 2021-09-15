<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => "Mon email",
                'disabled' => true
            ])
            ->add('firstname', TextType::class, [
                "disabled" => true,
                'label' => "Mon prénom"
            ])
            ->add('lastname', TextType::class, [
                "disabled" => true,
                'label' => "Mon nom"
            ])
            ->add('oldPassword', PasswordType::class, [
                "mapped" => false,
                "label" => "Mon mot de passe actuel", 
                "attr" => [
                    "placeholder" => "Mot de passe"
                ]
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                "mapped" => false,
                'invalid_message' => 'Les mots de passes ne sont pas identiques',
                "required" => true,
                'first_options' => [
                    'label' => "Mon nouveau mot de passe",
                    'attr' => [
                        "placeholder" => "Mot de passe"
                    ]
                    ],
                'second_options' => [
                    'label' => "Confirmer le nouveau mot de passe",
                    "attr" => [
                        'placeholder' => "Mot de passe"
                    ]
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Modifier"
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
