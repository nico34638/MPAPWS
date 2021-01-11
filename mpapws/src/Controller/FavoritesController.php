<?php


namespace App\Controller;


use App\Domain\Command\AddFollowingCommand;
use App\Domain\Command\AddFollowingHandler;
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
     */
    public function addFavorites(User $producer, AddFollowingHandler $handler): Response
    {
        $currentUser = $this->getUser();
        $command  = new AddFollowingCommand($currentUser, $producer);
        $handler->handle($command);

        return $this->redirectToRoute('producers');
    }

}