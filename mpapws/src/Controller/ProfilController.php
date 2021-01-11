<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index(): Response
    {
        $user = $this->getUser();

        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController()',
            'username' => $user->getUsername(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'address' => $user->getAddress(),
            'email' => $user->getEmail(),
            'products' => $user->getProducts(),
        ]);
    }
}
