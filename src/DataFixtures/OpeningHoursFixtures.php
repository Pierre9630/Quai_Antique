<?php

namespace App\DataFixtures;

use App\Entity\OpeningHours;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OpeningHoursFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $openinghours = new OpeningHours();
        $openinghours->setDay(0);
        $openinghours->setOpenTime(\DateTime::createFromFormat('H:i','12:00'));
        $openinghours->setCloseTime(\DateTime::createFromFormat('H:i','14:00'));
        $manager->persist($openinghours);

        $openinghours = new OpeningHours();
        $openinghours->setDay(1);
        $openinghours->setOpenTime(\DateTime::createFromFormat('H:i','12:00'));
        $openinghours->setCloseTime(\DateTime::createFromFormat('H:i','14:00'));
        $manager->persist($openinghours);

        $openinghours = new OpeningHours();
        $openinghours->setDay(1);
        $openinghours->setOpenTime(\DateTime::createFromFormat('H:i','19:00'));
        $openinghours->setCloseTime(\DateTime::createFromFormat('H:i','21:00'));
        $manager->persist($openinghours);

        $openinghours = new OpeningHours();
        $openinghours->setDay(2);
        $openinghours->setOpenTime(\DateTime::createFromFormat('H:i','12:00'));
        $openinghours->setCloseTime(\DateTime::createFromFormat('H:i','14:00'));
        $manager->persist($openinghours);

        $openinghours = new OpeningHours();
        $openinghours->setDay(2);
        $openinghours->setOpenTime(\DateTime::createFromFormat('H:i','19:00'));
        $openinghours->setCloseTime(\DateTime::createFromFormat('H:i','21:00'));

        $manager->persist($openinghours);
        $manager->flush();
    }
}
