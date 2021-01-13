<?php


namespace App\Tests\Controller;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class FavoritesControllerTest
 * @package App\Tests\Controller
 */
class FavoritesControllerTest extends WebTestCase
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
     * Test display list of favroites
     */
    public function test_diplay_page_favorites()
    {
        $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('producteur@gmail.com');

        // simulate $testUser being logged in
        $this->client->loginUser($testUser);

        $crawler = $this->client->request('GET', '/favoris');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}