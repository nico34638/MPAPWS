<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class ProducteurFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++)
        {
            $user = new User();
            $user->setPrenom($faker->firstName);
            $user->setNom($faker->lastName);
            $user->setUsername($faker->name);
            $user->setEmail($faker->email);
            $user->setPassword($this->encoder->encodePassword($user, 'demo'));
            if($i % 2 == 0)
            {
                $user->setRoles(['ROLE_USER']);
            }
            else{
                $user->setRoles(['ROLE_PRODUCTEUR']);
            }
            $manager->persist($user);
        }

        $manager->flush();
    }
}
