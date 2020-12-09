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

        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++)
        {
            $produit = new Produit();
            if ($i % 2 == 0)
            {
                $produit->setNom("Bouglour");
            } else
            {
                $produit->setNom("Carotte");
            }

            $produit->setDescription($faker->text);
            $produit->setPrix(random_int(1, 155));
            $produit->setSourceImage("https://via.placeholder.com/150");
            $manager->persist($produit);
        }
        $manager->flush();
    }
}
