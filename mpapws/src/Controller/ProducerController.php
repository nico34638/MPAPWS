<?php

namespace App\Controller;

use App\Domain\Query\ListProducersHandler;
use App\Domain\Query\ListProducerQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProducerController extends AbstractController
{
    /**
     * @Route("/producteurs", name="producteurs")
     */
    public function index(ListProducersHandler $handler): Response
    {
        $query = new ListProducerQuery();
        $producers = $handler->handle($query);

        return $this->render('producteurs/index.html.twig', [
            'producers' => $producers
        ]);
    }
}
