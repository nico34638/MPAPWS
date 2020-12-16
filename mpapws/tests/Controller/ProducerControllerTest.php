<?php


namespace App\Tests\Controller;


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
    public function test_display_list_producers()
    {
        $this->client->request('GET', '/producteurs');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

}