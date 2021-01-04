<?php

namespace App\Controller;

use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search/{param}", name="search")
     */
    public function index($param): Response
    {

        

        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function searchNavBar(RequestStack $requestStack)
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($requestStack->getMasterRequest());

        if($form->isSubmitted() && $form->isValid())
        {
            $content = $form->getData()["content"];
            return $this->render('search/redirectToSearch.html.twig',[
                'content' => $content
            ]);
            //return $this->redirectToRoute('search');
            //($form->getData());
        }

        return $this->render('search/searchNavBar.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
