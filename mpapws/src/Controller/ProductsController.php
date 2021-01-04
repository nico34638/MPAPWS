<?php

namespace App\Controller;

use App\Domain\Command\AddProductCommand;
use App\Domain\Command\AddProductHandler;
use App\Domain\Query\ListProductsHandler;
use App\Domain\Query\ListProductsQuery;
use App\Domain\Query\OneProducerHandler;
use App\Domain\Query\OneProducerQuery;
use App\Domain\Query\OneProductHandler;
use App\Domain\Query\OneProductQuery;
use App\Entity\Product;
use App\Form\ProductType;
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
     * @return Response
     */
    public function listPrd(ListProductsHandler $handler): Response
    {
        $query = new ListProductsQuery();
        $products = $handler->handle($query);

        return $this->render('products/listProducts.html.twig', [
            'products' => $products,
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
                $img = Image::make($path)->resize(150, 150)->save();


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
}
