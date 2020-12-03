<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitsController extends AbstractController
{
    /**
     * @Route("/produits", name="produits")
     */
    public function index(): Response
    {
        $repository=$this->getDoctrine()->getManager()->getRepository('App\Entity\Produit');
        $produits=$repository->findAll();
        return $this->render('produits/index.html.twig', [
            'controller_name' => 'ProduitsController',
            'produits'=> $produits,
        ]);
    }
}
