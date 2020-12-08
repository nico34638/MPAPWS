<?php

namespace App\Controller;

use App\Domain\Query\ListeProducteursHandler;
use App\Domain\Query\ListeProducteursQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProducteurController extends AbstractController
{
    /**
     * @Route("/producteurs", name="producteurs")
     */
    public function index(ListeProducteursHandler $handler): Response
    {
        $query = new ListeProducteursQuery();
        $producteurs = $handler->handle($query);

        dd($producteurs);

        return $this->render('producteurs/index.html.twig', [
            'producteurs' => $producteurs
        ]);
    }
}
