<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExplanationController extends AbstractController
{
    /**
     * @Route("/fonctionnement", name="Fonctionnement de Farmeetic")
     */
    public function index(): Response
    {
        return $this->render('explanation/index.html.twig', [
            'controller_name' => 'ExplanationController',
        ]);
    }
}
