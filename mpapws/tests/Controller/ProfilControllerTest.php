<?php


namespace App\Tests\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfilControllerTest extends WebTestCase
{
    /**
     * @var KernelBrowser
     */

    /**
     * Method that runs before all tests
     */
    public function setUp(): void
    {
        $user1 = new User();
        $user1->setUsername("user1");
        $user1->setLastName("Dupont");
        $user1->setFisrtName("Maurice");
        $user1->setAddress("8 rue faubourd pont neuf");
        $user1->setEmail("email@email.com");
        $this->setUser($user1);
    }

    /**
     * Test
     */
    public function test_get_actual_user_value()
    {
        $userTest = $this->getUser();
        $this->assertEquals($userTest->getLastname,"Dupont");
    }

}