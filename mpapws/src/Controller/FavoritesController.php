<?php


namespace App\Controller;


use App\Domain\Command\AddFollowingCommand;
use App\Domain\Command\AddFollowingHandler;
use App\Domain\Query\ListOfFavoritesHandler;
use App\Domain\Query\ListOfFavoritesQuery;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoritesController extends AbstractController
{

    /**
     * @Route("/favoris/add/{producer}", name="addFavorites")
     * @param User $producer
     * @param AddFollowingHandler $handler
     * @return Response
     */
    public function addFavorites(User $producer, AddFollowingHandler $handler): Response
    {
        $currentUser = $this->getUser();
        $command  = new AddFollowingCommand($currentUser, $producer);
        $handler->handle($command);

        return $this->redirectToRoute('producers');
    }

    /**
     * @Route("/favoris", name="listFavorites")
     * @param ListOfFavoritesHandler $handler
     * @return Response
     */
    public function listFavorites(ListOfFavoritesHandler $handler):Response
    {
        $query = new ListOfFavoritesQuery($this->getUser());
        $favorites = $handler->handle($query);

        return $this->render('favorites/listOfFavorites.html.twig', [
            'favorites'=> $favorites
            ]);
    }

}