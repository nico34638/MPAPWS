<?php

namespace App\Controller;

use App\Domain\Query\ListProductsHandler;
use App\Domain\Query\ListProductsQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    /**
     * @Route("/produits", name="products")
     * @param ListProductsHandler $handler
     * @return Response
     */
    public function listPrd(ListProductsHandler $handler): Response
    {
        $query= new ListProductsQuery();
        $products= $handler->handle($query);

        return $this->render('products/listProducts.html.twig', [
            'products'=> $products,
        ]);
    }

    /**
     * @Route("/produits/ajouter", name="addProduct")
     * @param Request $request
     */
    public function addProduct(Request $request): Response
    {

    }
}
