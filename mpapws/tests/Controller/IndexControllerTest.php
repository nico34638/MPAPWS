<?php


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class IndexControllerTest
 * @package App\Tests\Controller
 */
class IndexControllerTest extends WebTestCase
{

    /**
     * @var \Symfony\Bundle\FrameworkBundle\KernelBrowser
     */
    private $client;

    /**
     * Fonction qui s'écute avant tous les tests
     */
    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * Test page index
     */
    public function test_page_index()
    {
        $this->client->request('GET', '/');
        $this->assertEquals(200,  $this->client->getResponse()->getStatusCode());
    }
}