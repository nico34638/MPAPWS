<?php


namespace App\Controller;


use App\Domain\Command\AddFollowingCommand;
use App\Domain\Command\AddFollowingHandler;
use App\Domain\Command\DeleteFollowingCommand;
use App\Domain\Command\DeleteFollowingHandler;
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
     * @Route("/favoris/ajouter/{producer}", name="addFavorites")
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
     * @Route("/favoris/supprimer/{producer}", name="deleteFavorites")
     * @param User $producer
     * @param DeleteFollowingHandler $handler
     * @return Response
     */
    public function deleteFavorite(User $producer, DeleteFollowingHandler $handler): Response
    {
        $currentUser = $this->getUser();
        $command  = new DeleteFollowingCommand($currentUser, $producer);
        $handler->handle($command);

        return $this->redirectToRoute('producers');
    }




    /**
     * @Route("/favoris/addFromDetails/{producer}", name="addFavoritesFromDetail")
     * @param User $producer
     * @param AddFollowingHandler $handler
     * @return Response
     */
    public function addFavoritesFromDetails(User $producer, AddFollowingHandler $handler): Response
    {
        $currentUser = $this->getUser();
        $command  = new AddFollowingCommand($currentUser, $producer);
        $handler->handle($command);

        return $this->redirectToRoute('detailproducers',['username'=>$producer->getUsername()]);
    }
    /**
     * @Route("/favoris/deleteFromDetails/{producer}", name="deleteFavoritesFromDetails")
     * @param User $producer
     * @param DeleteFollowingHandler $handler
     * @return Response
     */
    public function deleteFavoriteFromDetails(User $producer, DeleteFollowingHandler $handler): Response
    {
        $currentUser = $this->getUser();
        $command  = new DeleteFollowingCommand($currentUser, $producer);
        $handler->handle($command);

        return $this->redirectToRoute('detailproducers',['username'=>$producer->getUsername()]);
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