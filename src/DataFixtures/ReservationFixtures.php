<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\Validator\Constraints\DateTime;

/*https://symfonycasts.com/screencast/symfony2-ep3/sharing-data-fixtures
https://stackoverflow.com/questions/67157254/inserting-the-current-date-doctrine*/
class ReservationFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $Kath = $manager->getRepository(User::class)
            ->findOneBy(array('email' =>'Kath@vodafone.de'));
        // $product = new Product();
        // $manager->persist($product);
        $res = new Reservation();

        $res->setUserRes($Kath);//$this->getReference('user-reference'));
        //$datekath = new DateTime(,);
        $res->setDateRes(\DateTime::createFromFormat('Y-m-d H:i:s','2023-05-02 12:30:00'));
        $res->setNbCutlery(2);
        $now = new \DateTimeImmutable();
        $res->setReservationAt($now);
        $manager->persist($res);
        $manager->flush();
    }

    public function getOrder()
    {
        // TODO: Implement getOrder() method.
        return 20;
    }
}
