<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Domain\Query\ListeProducteursHandler;
use App\Domain\Query\ListeProducteursQuery;
use App\Domain\Query\ListeProduitsHandler;
use App\Domain\Query\ListeProduitsQuery;
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
     * @param ListeProduitsHandler $handler
     * @return Response
     */
    public function index(ListeProduitsHandler $productHandler,ListeProducteursHandler $producerHandler): Response
    {
        $productQuery= new ListeProduitsQuery();
        $allProducts= $productHandler->handle($productQuery);

        $producerQuery= new ListeProducteursQuery();
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
