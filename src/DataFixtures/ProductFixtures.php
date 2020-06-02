<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    const NB_PRODUCTS = 50;

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < self::NB_PRODUCTS; $i++) {
            $product = new Product();

            $product->setName("Mon produit $i")
                ->setDescription("Ma super description $i")
                ->setPrice(random_int(100, 100000))
                ->setRef(substr(str_shuffle(md5(random_int(0, 1000000))), 0, 25))
                ->setUser($this->getReference('user' . random_int(0, UserFixtures::NB_USER)))
            ;

            $manager->persist($product);
        }

        $manager->flush();
    }
}
