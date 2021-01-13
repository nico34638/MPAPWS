<?php


namespace App\Tests\Controller;


use App\Domain\CatalogOfProducers;
use App\Domain\Query\ListProducersHandler;
use App\Domain\Query\ListProducersQuery;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ProducerControllerTest
 * @package App\Tests\Controller
 */
class ProducerControllerTest extends WebTestCase
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
     * Test for the displaying of the list of producers
     */
    public function test_display_page_list_producers()
    {
        $this->client->request('GET', '/producteurs');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test list of producers
     */
    public function test_display_list_producers()
    {
        $userRepository = static::$container->get(UserRepository::class);

        $producers = $userRepository->allProducers();

        $crawler = $this->client->request('GET', '/producteurs');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertCount(count($producers), $crawler->filter('div.card-perso'));
    }

    /**
     * Test display producer detail
     */
    public function test_display_producer_detail()
    {
        $this->client->request('GET', '/producteurs/producteur');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

}