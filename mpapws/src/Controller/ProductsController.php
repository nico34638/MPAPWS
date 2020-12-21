<?php

namespace App\Controller;

use App\Domain\Command\AddProductCommand;
use App\Domain\Command\AddProductHandler;
use App\Domain\Query\ListProductsHandler;
use App\Domain\Query\ListProductsQuery;
use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

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
     * @Route("/produits/admin/ajouter", name="addProduct")
     * @param Request $request
     */
    public function addProduct(Request $request, AddProductHandler $handler, Security $security): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid())
        {
            $product->setSourceImage('https://via.placeholder.com/150/93A8AC/000000?Text=FarMeetic');
            $product->setProducers($security->getUser());

            $command = new AddProductCommand($product);
            $handler->handle($command);
        }

        return $this->render('products/admin/addProduct.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
