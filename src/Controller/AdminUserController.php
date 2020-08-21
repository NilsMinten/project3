<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /** @Route(path="/admin/users", name="admin_user_overview") */
    public function index(Request $request) {
        $users = $this->userRepository->findAll();

        return $this->render('admin/users/index.html.twig', [
            'users' => $users
        ]);
    }

    /** @Route(path="/admin/user/{id}", name="admin_user_details") */
    public function userDetails(Request $request, User $user) {
        return $this->render('admin/users/details.html.twig', [
            'user' => $user
        ]);
    }

    /** @Route(path="/admin/user/{id}/edit", name="admin_user_edit") */
    public function userEdit(Request $request, User $user) {
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isSubmitted()) {
            $this->userRepository->save($user);

            return $this->getUser() === $user ? $this->redirectToRoute('login') : $this->redirectToRoute('admin_user_details', ['id' => $user->getId()]);
        }

        return $this->render('admin/users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /** @Route(path="/admin/user/{id}/delete", name="admin_user_delete_confirm") */
    public function confirmUserDelete(Request $request, User $user) {
        return $this->render('admin/users/delete_confirm.html.twig', [
            'user' => $user,
        ]);
    }

    /** @Route(path="/admin/user/{id}/delete/confirm", name="admin_user_delete") */
    public function userDelete(Request $request, User $user) {
        $this->userRepository->delete($user);

        return $this->redirectToRoute('admin_user_overview');
    }
}