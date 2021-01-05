<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class SearchControllerTest
 * @package App\Tests\Controller
 */
class SearchControllerTest extends WebTestCase
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
     * Test search page
     */
    public function test_search_page()
    {
        $this->client->request('GET', '/search/test');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}