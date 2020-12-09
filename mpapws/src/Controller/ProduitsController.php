<?php

namespace App\Controller;

use App\Domain\Query\ListeProduitsHandler;
use App\Domain\Query\ListeProduitsQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitsController extends AbstractController
{
    /**
     * @Route("/produits", name="produits")
     * @param ListeProduitsHandler $handler
     * @return Response
     */
    public function listePrd(ListeProduitsHandler $handler): Response
    {
        $query= new ListeProduitsQuery();
        $produits= $handler->handle($query);
        return $this->render('produits/listeProduits.html.twig', [
            'controller_name' => 'ProduitsController',
            'produits'=> $produits,
        ]);
    }
}
