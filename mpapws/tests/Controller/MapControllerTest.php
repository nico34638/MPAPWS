<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class MapControllerTest
 * @package App\Tests\Controller
 */
class MapControllerTest extends WebTestCase
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
     * Test for the displaying of the page map
     */
    public function test_display_page()
    {
        $this->client->request('GET', '/carte');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test div mapid exist
     */
    public function test_display_map()
    {
        $crawler = $this->client->request('GET', '/carte');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $crawler->matches('div#mapid');
    }

}