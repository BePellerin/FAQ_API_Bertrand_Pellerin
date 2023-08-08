<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $tab = array(
            array('username' => 'Admin', 'roles' => ["ROLE_ADMIN"], 'password' => 'admin', 'picture' => " "),
            array('username' => 'User', 'roles' => ["ROLE_USER"], 'password' => 'user', 'picture' => " ")
        );

        foreach ($tab as $row) {
            $user = new User();
            $user->setUsername($row['username']);
            $user->setRoles($row['roles']);
            $user->setPassword($this->hasher->hashPassword($user, $row['password']));
            $manager->persist($user);
        }
        $manager->flush();
    }
}
