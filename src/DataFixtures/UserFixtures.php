<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    const Emails = [
        'John@thebest.us',
        'Kath@vodafone.de',
        'Aziz@gmail.ly',
        'Vlad@runet.ru',
    ];
    const Pass = [
        'America!',
        'Deutschland!',
        'Libia!',
        'Russia!',
    ];
    const FirstNames = [
        'Doe',
        'Neu',
        'Abdel',
        'Poutine',
    ];

    const LastNames = [
        'John',
        'Katherine',
        'Aziz',
        'Vladmir',
    ];

    const PhoneNumbers = [
        '19631776',
        '19891939',
        '9112001',
        '19452022',
    ];

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
        /*$this->factory = new PasswordHasherFactory([
        'common' => ['algorithm' => 'bcrypt'],
        'sodium' => ['algorithm' => "sodium"],
        ]);*/
    }

    public function load(ObjectManager $manager): void
    {

        foreach (self::Emails as $Index => $Emails){
            $user = new User();
            $user->setEmail($Emails);

            $password = $this->hasher->hashPassword($user,self::Pass[$Index]);
            $user->setPassword($password);
            $user->setFirstname(self::FirstNames[$Index]);
            $user->setLastname(self::LastNames[$Index]);
            $user->setPhone(self::PhoneNumbers[$Index]);
            /*if($Index == 3){
                dd($UserName.' '. self::Pass[$Index]);
            }*/

            $manager->persist($user);
        }

        //$manager->persist($user);
        $manager->flush();
        // $product = new Product();
        // $manager->persist($product);
        /*
        $user = new User(); //Pensez bien à ajouter le use App\Entity\User en haut du fichier !
        $user->setUsername('John');
        */
        //$this->hashPassword->$user->setPassword('test');
        //$hasher = $this->factory->getPasswordHasher('common');
        /*
        $password = $this->hasher->hashPassword($user,'test');
        $user->setPassword($password);
        $user->setName("John Doe");
        $manager->persist($user);
        $manager->flush();
        */
    }
}
/*
 * Hashing a Stand-Alone String
The password hasher can be used to hash strings independently of users. By using the PasswordHasherFactory,
 you can declare multiple hashers, retrieve any of them with its name and create hashes.
 You can then verify that a string matches the given hash:
 * use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;

// configure different hashers via the factory
$factory = new PasswordHasherFactory([
    'common' => ['algorithm' => 'bcrypt'],
    'sodium' => ['algorithm' => 'sodium'],
]);

// retrieve the hasher using bcrypt
$hasher = $factory->getPasswordHasher('common');
$hash = $hasher->hash('plain');

// verify that a given string matches the hash calculated above
$hasher->verify($hash, 'invalid'); // false
$hasher->verify($hash, 'plain'); // true
 */