<?php


namespace App\Tests\Controller;


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
    public function test_display_list_products()
    {
        $this->client->request('GET', '/produits');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}

