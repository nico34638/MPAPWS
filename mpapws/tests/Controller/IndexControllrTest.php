<?php


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class IndexControllrTest
 * @package App\Tests\Controller
 */
class IndexControllrTest extends WebTestCase
{

    /**
     * Test page index
     */
    public function test_page_index()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}