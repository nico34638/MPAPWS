<?php


namespace App\Tests\Controller;


use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ProductControllerTest
 * @package App\Tests\Controller
 */
class ProductControllerTest extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    private $client;

    /**
     * Method that runs before all tests
     */
    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * Test for the displaying of the list of products
     */
    public function test_display_page_list_products()
    {
        $this->client->request('GET', '/produits');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test diplay list product and count number products
     */
    public function test_display_list_products()
    {
        $productRepository = static::$container->get(ProductRepository::class);

        $producers = $productRepository->findAll();

        $crawler = $this->client->request('GET', '/produits');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertCount(count($producers), $crawler->filter('div.card-perso'));

    }

    /**
     * Test for the displaying of the details of a product
     */
    public function test_display_product_details()
    {
        $productRepository = static::$container->get(ProductRepository::class);

        $products = $productRepository->findAll();

        $this->client->request('GET', '/produits/'. $products[0]->getId());
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @test to list displaying of the form of product
     */
    public function test_display_form_add_producer()
    {
        $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('producteur@gmail.com');

        // simulate $testUser being logged in
        $this->client->loginUser($testUser);

        // test e.g. the profile page
        $this->client->request('GET', '/admin/produits/ajouter');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function test_products_of_a_producer()
    {
        $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('producteur@gmail.com');

        // simulate $testUser being logged in
        $this->client->loginUser($testUser);

        $this->client->request('GET', '/admin/produits/mesproduits');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function test_modification_of_a_product_of_a_producer()
    {
        $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('karim.boulgour@farm.com');

        // simulate $testUser being logged in
        $this->client->loginUser($testUser);

        $products = $testUser->getProducts();

        $this->client->request('GET', '/admin/produits/mesproduits/'. $products[0]->getId());
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

}

