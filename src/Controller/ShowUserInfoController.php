<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowUserInfoController extends AbstractController
{
    #[Route('/show/user/info', name: 'app_show_user_info')]
    public function index(): Response
    {
        return $this->render('show_user_info/index.html.twig', [
            'controller_name' => 'ShowUserInfoController',
        ]);
    }
}
