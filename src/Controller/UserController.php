<?php

namespace App\Controller;

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
}
