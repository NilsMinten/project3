<?php
namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $formFactory;
    private $userRepository;
    private $userPasswordEncoder;

    public function __construct(FormFactoryInterface $formFactory, UserRepository $userRepository, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->formFactory = $formFactory;
        $this->userRepository = $userRepository;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }


    /** @Route(path="/login", name="login") */
    public function login(Request $request, AuthenticationUtils $authenticationUtils) {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }



}