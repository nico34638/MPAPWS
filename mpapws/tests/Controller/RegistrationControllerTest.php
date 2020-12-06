<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class RegistrationControllerTest
 * @package App\Tests\Controller
 */
class RegistrationControllerTest extends WebTestCase
{

    /**
     * Test page register
     */
    public function test_page_register()
    {
        $client = static::createClient();
        $client->request('GET', '/register');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}