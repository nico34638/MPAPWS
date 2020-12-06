<?php


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class IndexControllrTest
 * @package App\Tests\Controller
 */
class IndexControllrTest extends WebTestCase
{

    private $client;

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