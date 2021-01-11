<?php


namespace App\Controller;


use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoritesController extends AbstractController
{

    /**
     * @Route("/favorites/add/{id_producer}", name="addFavorites")
     */
    public function addFavorites(User $id_producer, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser();

        return $this->redirectToRoute('producers');
    }

}