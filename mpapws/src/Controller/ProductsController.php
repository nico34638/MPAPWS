<?php

namespace App\Controller;

use App\Domain\Command\AddProductCommand;
use App\Domain\Command\AddProductHandler;
use App\Domain\Command\DeleteProductCommand;
use App\Domain\Command\DeleteProductHandler;
use App\Domain\Query\ListProducersHandler;
use App\Domain\Query\ListProducersQuery;
use App\Domain\Query\ListProductsHandler;
use App\Domain\Query\ListProductsQuery;
use App\Domain\Query\OneProducerHandler;
use App\Domain\Query\OneProducerQuery;
use App\Domain\Query\OneProductHandler;
use App\Domain\Query\OneProductQuery;
use App\Entity\Product;
use App\Entity\User;
use App\Form\ProductType;
use App\Form\SearchType;
use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductsController extends AbstractController
{

    /**
     * @Route("/produits", name="products")
     * @param ListProductsHandler $handler
     * @param Request $request
     * @return Response
     */
    public function listProduct(ListProductsHandler $handler, Request $request): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $content = $form->getData()["content"];
            return $this->redirectToRoute('searchParam', ['param' => $content]);

        }

        $query = new ListProductsQuery();
        $products = $handler->handle($query);

        return $this->render('products/listProducts.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/produits/{id}", name="productDetails")
     * @param OneProductHandler $handler
     * @param $id
     * @return Response
     */
    public function detailsPrd(OneProductHandler $handler, $id): Response
    {
        $query = new OneProductQuery();
        $product = $handler->handle($query, $id);


        return $this->render('products/detailsProduct.html.twig', [
            'product' => $product,
            'producer' => $product->getProducers(),
        ]);
    }

    /**
     * @Route("/admin/produits/ajouter", name="addProduct")
     * @param Request $request
     * @param AddProductHandler $handler
     * @param Security $security
     * @param SluggerInterface $slugger
     * @return Response
     */
    public function addProduct(Request $request, AddProductHandler $handler, Security $security, SluggerInterface $slugger): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $file = $form->get('imageFile')->getData();
            if ($file)
            {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
                // Move the file to the directory where brochures are stored
                try
                {
                    $file->move(
                        $this->getParameter('products_directory'),
                        $newFilename
                    );
                } catch (FileException $e)
                {
                }

                $path = "uploads/products/" . $newFilename;
                // Resize image
                $img = Image::make($path)->resize(250, 250)->save();


                $product->setSourceImage($path);
            } else
            {
                $product->setSourceImage('https://via.placeholder.com/150/93A8AC/000000?Text=FarMeetic');
            }


            $product->setProducers($security->getUser());
            $command = new AddProductCommand($product);
            $handler->handle($command);

            return $this->redirectToRoute('products');
        }

        return $this->render('products/admin/addProduct.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/produits/{id}", name="deleteProduct", methods="DELETE")
     * @param Product $product
     * @return Response
     */
    public function deleteProduct(Product $product, DeleteProductHandler $handler): Response
    {
        $command = new DeleteProductCommand($product);
        $handler->handle($command);
        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/admin/produits/mesproduits", name="mesproduits")
     * @return Response
     */
    public function myProduct(): Response
    {
        $currentProducer = $this->getUser();

        return $this->render('products/admin/productsOfProducer.html.twig', [
            'currentProducer' => $currentProducer,
        ]);
    }

    /**
     * @Route("/admin/produits/mesproduits/{id}", name="ModifProduct")
     * @param $id
     * @return Response
     */
    public function modificationOfMyProduct(Request $request, OneProductHandler $handler, $id, AddProductHandler $Addhandler, Security $security, SluggerInterface $slugger): Response
    {
        $query = new OneProductQuery();
        $product = $handler->handle($query, $id);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $file = $form->get('imageFile')->getData();
            if ($file)
            {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
                // Move the file to the directory where brochures are stored
                try
                {
                    $file->move(
                        $this->getParameter('products_directory'),
                        $newFilename
                    );
                } catch (FileException $e)
                {
                }

                $path = "uploads/products/" . $newFilename;
                // Resize image
                $img = Image::make($path)->resize(250, 250)->save();


                $product->setSourceImage($path);
            } else
            {
                $product->setSourceImage('https://via.placeholder.com/150/93A8AC/000000?Text=FarMeetic');
            }


            $product->setProducers($security->getUser());
            $command = new AddProductCommand($product);
            $Addhandler->handle($command);

            return $this->redirectToRoute('mesproduits');
        }


        return $this->render('products/admin/ModifProduct.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }

}
