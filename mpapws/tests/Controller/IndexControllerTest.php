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

    /**
     * Check if list of products exist
     */
    public function test_list_of_products_in_index_page()
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertEquals(200,  $this->client->getResponse()->getStatusCode());
        $crawler->filter('div.card');
        $this->assertCount(12, $crawler->filter('div.card'));
    }

    /**
     * Test if button on index pgae exist
     */
    public function test_button_on_index_page()
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertEquals(200,  $this->client->getResponse()->getStatusCode());
        $link = $crawler->selectLink('Plus de produits')->link();
        $this->assertEquals('Plus de produits', $link->getNode()->firstChild->nodeValue);
        $this->client->click($link);
    }

}