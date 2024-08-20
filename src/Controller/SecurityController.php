<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class SecurityController extends AbstractController
{

    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $utils) : Response
    {
        $error=$utils->getLastAuthenticationError();
        $lastUsername=$utils->getLastUsername();
        return $this->render('login_singup/login.html.twig', [
               'error' => $error, 'last_username' => $lastUsername
        ]);
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {

    }
}
