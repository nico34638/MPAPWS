<?php


namespace App\Tests\Controller;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class RegistrationControllerTest
 * @package App\Tests\Controller
 */
class ProfilControllerTest extends WebTestCase
{

    /**
     * @var KernelBrowser
     */
    private KernelBrowser $client;

    /**
     * Method that runs before all tests
     */
    public function setUp(): void
    {
        $this->client = static::createClient();
    }


    public function test_profil_page()
    {
        $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('producteur@gmail.com');

        // simulate $testUser being logged in
        $this->client->loginUser($testUser);

        $this->client->request('GET', '/profil');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Test page modif-profil
     */
    public function test_modif_profil_page()
    {
        $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('producteur@gmail.com');

        // simulate $testUser being logged in
        $this->client->loginUser($testUser);
        $crawler = $this->client->request('GET', '/profil/modif-profil');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        //submit the form
        $form = $crawler->selectButton('Sauvegarder vos modifications')->form(array(
            'modify_profil[firstName]' => 'newFirst',
            'modify_profil[lastName]' => 'newLast',
            'modify_profil[username]' => 'newnew',
            'modify_profil[email]' => 'producteur@gmail.com',
            'modify_profil[password][first]' => '123',
            'modify_profil[password][second]' => '123',
            'modify_profil[address]' => 'newAdress',
            'modify_profil[imageFile]' => $testUser->getProfilImage()
        ));

        $this->client->submit($form);
        $this->assertEquals('App\Controller\ProfilController::modif', $this->client->getRequest()->attributes->get('_controller'));

        //test the validation of form
        $this->client->followRedirect();
        $this->assertEquals('App\Controller\ProfilController::index', $this->client->getRequest()->attributes->get('_controller'));
    }
}