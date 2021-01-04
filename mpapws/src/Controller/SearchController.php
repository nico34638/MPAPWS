<?php

namespace App\Controller;

use App\Domain\Query\SearchProductHandler;
use App\Domain\Query\SearchProductQuery;
use App\Entity\Product;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

class SearchController extends AbstractController
{

    /**
     * @Route("/search", name="search")
     */
    public function index(Request $request): Response
    {

        return $this->render('search/index.html.twig', [

        ]);
    }

    /**
     * @Route("/search/{param}", name="searchParam")
     * @param $param
     * @param Request $request
     * @param SearchProductHandler $handler
     * @return Response
     */
    public function searchWithParam($param, Request $request, SearchProductHandler $handler): Response
    {

        $query = new SearchProductQuery($param);
        $products = $handler->handle($query);


        return $this->render('search/searchResult.html.twig', [
            'products' => $products,
        ]);
    }


    /**
     * @param RequestStack $requestStack
     * @return Response
     */
    public function searchNavBar(RequestStack $requestStack): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($requestStack->getMasterRequest());

        if ($form->isSubmitted() && $form->isValid())
        {
            $content = $form->getData()["content"];
            return $this->render('search/redirectToSearch.html.twig', [
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
