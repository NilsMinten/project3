<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /** @Route(path="/my_account", name="my_account") */
    public function index() {
        return $this->render('account/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }
}