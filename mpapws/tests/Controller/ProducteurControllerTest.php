<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ProducteurControllerTest
 * @package App\Tests\Controller
 */
class ProducteurControllerTest extends WebTestCase
{

    /**
     * Test afficher la page lister les producteurs
     */
    public function test_afficher_liste_producteurs()
    {
        $client = static::createClient();
        $client->request('GET', '/producteurs');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}