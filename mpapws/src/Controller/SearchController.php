<?php

namespace App\Controller;

use App\Domain\Query\SearchProductHandler;
use App\Domain\Query\SearchProductQuery;
use App\Form\SearchType;
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
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $content = $form->getData()["content"];
            return $this->redirect('search/' . $content);
        }

        return $this->render('search/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/search/{param}", name="searchParam")
     * @param $param
     */
    public function searchWithParam($param, Request $request, SearchProductHandler $handler): Response
    {

        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $content = $form->getData()["content"];
            return $this->redirectToRoute('searchParam', ['param' => $content]);
        }

        $query = new SearchProductQuery($param);
        $products = $handler->handle($query);


        return $this->render('search/searchResult.html.twig', [
            'products' => $products,
            'param' => $param,
            'form' => $form->createView()
        ]);
    }


    public function searchNavBar(RequestStack $requestStack): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($requestStack->getMasterRequest());

        if ($form->isSubmitted() && $form->isValid())
        {
            $content = $form->getData()["content"];
            return new Response(
                "<script>
                window.location.href='/search/" . $content . "'
            </script>"
            );
        }

        return $this->render('search/searchNavBar.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
