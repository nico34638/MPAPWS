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

        $producteur = new User();
        $producteur->setFirstName($faker->firstName);
        $producteur->setLastName($faker->lastName);
        $producteur->setUsername($faker->name);
        $producteur->setEmail($faker->email);
        $producteur->setPassword($this->encoder->encodePassword($producteur, 'demo'));
        $producteur->setAddress("Rue de la Rochelle 17140 L'Houmeau");
        $producteur->setRoles(['ROLE_PRODUCER']);

        $karimBoulgour = new User();
        $karimBoulgour->setFirstName("Karim");
        $karimBoulgour->setLastName("Boulgour");
        $karimBoulgour->setUsername("KarimBoulgour69");
        $karimBoulgour->setEmail("karim.boulgour@farm.com");
        $karimBoulgour->setPassword($this->encoder->encodePassword($karimBoulgour, 'demo'));
        $karimBoulgour->setAddress("Rue de la République 17137 L'Houmeau");
        $karimBoulgour->setRoles(['ROLE_PRODUCER']);

        for ($i = 0; $i < 20; $i++)
        {
            $produit = new Product();
            if ($i % 2 == 0)
            {
                $produit->setName($faker->vegetableName());
                $produit->setSourceImage("https://via.placeholder.com/250/93A8AC/000000?Text=FarMeetic");
            } else
            {
                $produit->setName($faker->fruitName());
                $produit->setSourceImage("https://via.placeholder.com/250/424B54/FFFFFF?Text=FarMeetic");
            }

            $produit->setDescription($faker->text);
            $produit->setPrice(random_int(1, 155));
            $produit->setProducers($producteur);
            $manager->persist($produit);
        }

        $carrotte = new Product();
        $carrotte->setName("Carotte");
        $carrotte->setSourceImage("https://via.placeholder.com/250/93A8AC/000000?Text=FarMeetic");
        $carrotte->setDescription("Rien ne vaut une belle carotte");
        $carrotte->setPrice(random_int(1, 155));
        $carrotte->setProducers($producteur);
        $manager->persist($carrotte);

        $boulgour = new Product();
        $boulgour->setName("Boulgour");
        $boulgour->setSourceImage("https://via.placeholder.com/250/93A8AC/000000?Text=FarMeetic");
        $boulgour->setDescription("Rien ne vaut unbon boulgour fait par Karim");
        $boulgour->setPrice(random_int(1, 155));
        $boulgour->setProducers($producteur);
        $manager->persist($boulgour);

        $manager->flush();
    }
}
