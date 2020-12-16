<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class RegistrationControllerTest
 * @package App\Tests\Controller
 */
class RegistrationControllerTest extends WebTestCase
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
     * Test register page
     */
    public function test_register_page()
    {
        $this->client->request('GET', '/register');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}