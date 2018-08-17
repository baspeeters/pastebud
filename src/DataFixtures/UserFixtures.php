<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('user-1');
        $user->setEmail('user-1@foo.bar');
        $user->setPlainPassword('test123');

        $manager->persist($user);
        $manager->flush();
    }
}
