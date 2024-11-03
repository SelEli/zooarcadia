<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test')]
    public function test(): Response
    {
        $user = $this->getUser();
        
        if (!$user) {
            return new Response('No user is currently logged in.');
        }

        $roles = $user->getRoles();
        return new Response('User roles: ' . implode(', ', $roles));
    }
}
