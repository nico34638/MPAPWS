<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProductFixtures extends Fixture
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

        $faker = \Faker\Factory::create('fr_FR');
        $faker->addProvider(new \FakerRestaurant\Provider\fr_FR\Restaurant($faker));

        $user1 = new User();
        $user1->setFirstName($faker->firstName);
        $user1->setLastName($faker->lastName);
        $user1->setUsername($faker->name);
        $user1->setEmail($faker->email);
        $user1->setPassword($this->encoder->encodePassword($user1, 'demo'));
        $user1->setAddress($faker->address);
        $user1->setRoles(['ROLE_PRODUCER']);

        for ($i = 0; $i < 20; $i++)
        {
            $produit = new Product();
            if ($i % 2 == 0)
            {
                $produit->setName($faker->vegetableName());
                $produit->setSourceImage("https://via.placeholder.com/150/93A8AC/000000?Text=FarMeetic");
            } else
            {
                $produit->setName($faker->fruitName());
                $produit->setSourceImage("https://via.placeholder.com/150/424B54/FFFFFF?Text=FarMeetic");
            }

            $produit->setDescription($faker->text);
            $produit->setPrice(random_int(1, 155));
            $produit->setProducers($user1);
            $manager->persist($produit);
        }
        $manager->flush();
    }
}
