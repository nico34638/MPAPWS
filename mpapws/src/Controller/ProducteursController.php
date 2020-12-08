<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProducteursController extends AbstractController
{
    /**
     * @Route("/producteurs", name="producteurs")
     */
    public function index(): Response
    {
        return $this->render('producteurs/index.html.twig', [
            'controller_name' => 'ProducteursController',
        ]);
    }
}
