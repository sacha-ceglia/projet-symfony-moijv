<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user-list", name="list_user")
     */
    public function index(UserRepository $userRepository)
    {
        // $userList = $pdo->query("SELECT * from user")->fetchAll();
        $userList = $userRepository->findAll();

        return $this->render('user/index.html.twig', [
            'user_list' => $userList,
        ]);
    }

    /**
     * @Route("/user/{id<\d+>}", name="user")
     */
    public function detail(User $user)
    {
        return $this->render('user/detail.html.twig', [
            'user' => $user,
        ]);
    }
}
