<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AccountPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/compte/mot-de-passe", name="account_password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {

        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        
        $form->handleRequest($request);

        $notification = null;
        if( $form->isSubmitted() && $form->isValid() ) {
            $oldPassword = $form->get('oldPassword')->getData();

            if( $encoder->isPasswordValid($user, $oldPassword) ) {
                $newPassword = $form->get('newPassword')->getData();
                $password = $encoder->encodePassword($user, $newPassword);

                $user->setPassword($password);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $notification = "Mot de passe mis à jour avec succès !";
            } else {
                $notification = "Echec dans la mise à jour du mot de passe !";
            }
        }


        return $this->render('account/password.html.twig', [
            "form" => $form->createView(),
            "notification" => $notification
        ]);
    }
}
