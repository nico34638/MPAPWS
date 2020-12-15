<?php

namespace App\Controller;

use App\Domain\Query\ListeProductsHandler;
use App\Domain\Query\ListeProductsQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    /**
     * @Route("/produits", name="produits")
     * @param ListeProductsHandler $handler
     * @return Response
     */
    public function listePrd(ListeProductsHandler $handler): Response
    {
        $query= new ListeProductsQuery();
        $produits= $handler->handle($query);
        return $this->render('produits/listeProduits.html.twig', [
            'controller_name' => 'ProductsController',
            'produits'=> $produits,
        ]);
    }
}
