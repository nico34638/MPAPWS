<?php

namespace App\Controller;

use App\Entity\Product;
use App\Domain\Query\ListProducersHandler;
use App\Domain\Query\ListProducerQuery;
use App\Domain\Query\ListeProductsHandler;
use App\Domain\Query\ListeProductsQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 * Main controller
 * @package App\Controller
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param ListeProductsHandler $handler
     * @return Response
     */
    public function index(ListeProductsHandler $productHandler, ListProducersHandler $producerHandler): Response
    {
        $productQuery= new ListeProductsQuery();
        $allProducts= $productHandler->handle($productQuery);

        $producerQuery= new ListProducerQuery();
        $allProducers= $producerHandler->handle($producerQuery);


        $nbProducts = count($allProducts);
        $nbProducer = count($allProducers);
        $products = array();

        for ($i = 1; $i <= 12; $i++){
            array_push($products,$allProducts[rand(0,$nbProducts-1)]);
        }

        return $this->render('index/index.html.twig', [
            'products'=>$products,
            'nbProducts'=>$nbProducts,
            'nbProducer'=>$nbProducer,
        ]);
    }
}
