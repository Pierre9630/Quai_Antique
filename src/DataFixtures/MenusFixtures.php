<?php

namespace App\DataFixtures;

use App\Entity\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MenusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $product = new Menu();
        $product->setTitle("Pizza Chorizo");
        $product->setDescription('une bonne pizza bien frâiche avec du parmesan du chorizo et de la mozarella');
        $product->setPrice(4.55);
        $manager->persist($product);
        $manager->flush();
    }
}
