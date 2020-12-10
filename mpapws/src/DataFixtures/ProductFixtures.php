<?php

namespace App\DataFixtures;

use App\Entity\Produit;
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
            $produit = new Produit();
            if ($i % 2 == 0)
            {
                $produit->setNom($faker->vegetableName());
                $produit->setSourceImage("https://via.placeholder.com/150/93A8AC/000000?Text=FarMeetic");
            } else
            {
                $produit->setNom($faker->fruitName());
                $produit->setSourceImage("https://via.placeholder.com/150/424B54/FFFFFF?Text=FarMeetic");
            }

            $produit->setDescription($faker->text);
            $produit->setPrix(random_int(1, 155));
            $manager->persist($produit);
        }
        $manager->flush();
    }
}
