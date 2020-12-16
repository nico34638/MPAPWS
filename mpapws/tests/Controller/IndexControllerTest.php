<?php


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class IndexControllerTest
 * @package App\Tests\Controller
 */
class IndexControllerTest extends WebTestCase
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
     * Test page index
     */
    public function test_index_page()
    {
        $this->client->request('GET', '/');
        $this->assertEquals(200,  $this->client->getResponse()->getStatusCode());
    }
}