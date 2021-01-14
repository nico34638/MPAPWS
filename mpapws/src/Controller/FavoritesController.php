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
     * @Route("/favoris/deleteFromList/{producer}", name="deleteFavoritesFromList")
     * @param User $producer
     * @param DeleteFollowingHandler $handler
     * @return Response
     */
    public function deleteFavoriteFromList(User $producer, DeleteFollowingHandler $handler): Response
    {
        $currentUser = $this->getUser();
        $command  = new DeleteFollowingCommand($currentUser, $producer);
        $handler->handle($command);

        return $this->redirectToRoute('listFavorites');
    }

    /**
     * @Route("/favoris", name="listFavorites")
     * @param ListOfFavoritesHandler $handler
     * @return Response
     */
    public function listFavorites(ListOfFavoritesHandler $handler, ListOfFavoritesHandler $favoritesHandler):Response
    {
        $query = new ListOfFavoritesQuery($this->getUser());
        $favorites = $handler->handle($query);

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
        return $this->render('favorites/listOfFavorites.html.twig', [
            'favorites'=> $favorites,
            'followings' => $id_tab
            ]);
    }

}