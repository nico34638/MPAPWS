<?php

namespace App\Controller;

use App\Domain\Query\ListProducersHandler;
use App\Domain\Query\ListProducersQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MapController extends AbstractController
{
    /**
     * @Route("/carte", name="map")
     */
    public function index(ListProducersHandler $producersHandler): Response
    {
        $query = new ListProducersQuery();
        $producers = $producersHandler->handle($query);
        return $this->render('map/index.html.twig', [
            'producers' => $producers,
        ]);
    }
}
