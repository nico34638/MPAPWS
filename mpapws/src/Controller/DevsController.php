<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DevsController extends AbstractController
{
    /**
     * @Route("/devs", name="devs")
     */
    public function index(): Response
    {
        return $this->render('devs/devs.html.twig', [
            'controller_name' => 'DevsController',
        ]);
    }
}