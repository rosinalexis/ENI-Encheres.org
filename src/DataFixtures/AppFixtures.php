<?php

namespace App\DataFixtures;

use App\Entity\Category;
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
        $this->laodUsers($manager);
        $this->loadCategories($manager);
    }

    public function laodUsers(ObjectManager $manager): void
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

            $this->setReference('user_' . $i, $user);
        }

        $manager->flush();
    }

    public function loadCategories(ObjectManager $manager): void
    {
        $lstCategories  = ['Appareil électroménager', 'Appareil électronique', 'Jouet', 'Ustensile', 'Meuble'];

        foreach ($lstCategories as $category) {
            $newCategory = new Category;
            $newCategory->setTitle($category);
            $manager->persist($newCategory);
        }

        $manager->flush();
    }
}
