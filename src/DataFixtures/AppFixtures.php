<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $faker;
    private $hash;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->faker = Factory::create('fr_FR');
        $this->hash = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $this->laodUser($manager);
    }

    public function laodUser(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $user = new User;
            $user->setEmail($this->faker->email())
                ->setRoles($this->faker->randomElement([['ROLE_USER'], ['ROLE_ADMIN']]))
                ->setPassword($this->hash->hashPassword($user, '123456'))
                ->setNickName($this->faker->userName())
                ->setFirstName($this->faker->firstName())
                ->setLastName($this->faker->lastName())
                ->setPhoneNumber($this->faker->phoneNumber())
                ->setStreet($this->faker->streetName())
                ->setPostcode(intval($this->faker->postcode()))
                ->setCity($this->faker->city())
                ->setCredit(0);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
