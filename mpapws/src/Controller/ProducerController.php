<?php

namespace App\Controller;

use App\Domain\Query\ListOfFavoritesHandler;
use App\Domain\Query\ListOfFavoritesQuery;
use App\Domain\Query\ListProducersHandler;
use App\Domain\Query\ListProducersQuery;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProducerController extends AbstractController
{
    /**
     * @Route("/producteurs", name="producers")
     * @param ListProducersHandler $handler
     * @return Response
     */
    public function index(ListProducersHandler $handler, UserRepository $repository, ListOfFavoritesHandler $favoritesHandler): Response
    {
        $query = new ListProducersQuery();
        $producers = $handler->handle($query);

        $id_tab = [];
        if ($this->getUser())
        {
            $queryFavorites = new ListOfFavoritesQuery($this->getUser());
            $favorites = $favoritesHandler->handle($queryFavorites);


            foreach ($favorites as $value)
            {
                array_push($id_tab, $value->getId());
            }
        }

        return $this->render('producers/listProducers.html.twig', [
            'producers' => $producers,
            'followings' => $id_tab
        ]);
    }
}
