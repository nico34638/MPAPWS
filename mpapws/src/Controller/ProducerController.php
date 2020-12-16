<?php

namespace App\Controller;

use App\Domain\Query\ListProducersHandler;
use App\Domain\Query\ListProducersQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProducerController extends AbstractController
{
    /**
     * @Route("/producers", name="producers")
     * @param ListProducersHandler $handler
     * @return Response
     */
    public function index(ListProducersHandler $handler): Response
    {
        $query = new ListProducersQuery();
        $producers = $handler->handle($query);

        return $this->render('listProducers.html.twig', [
            'producers' => $producers
        ]);
    }
}
