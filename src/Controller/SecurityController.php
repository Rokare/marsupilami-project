<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="security")
     */
    public function index()
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }


    /**
     * @Route("/connexion", name="login")
     */
    public function login() {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/logout",name="logout")
     */

    public function logout() {
        $this->redirectToRoute('logout');
    }

    /**
     * @Route("/profil",name="profil")
     */
    public function profil() {
    return $this->render('site/profil.html.twig');
    }

}
