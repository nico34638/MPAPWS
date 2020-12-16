<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = \Faker\Factory::create('fr_FR');
        $faker->addProvider(new \FakerRestaurant\Provider\fr_FR\Restaurant($faker));

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
            $manager->persist($produit);
        }
        $manager->flush();
    }
}
