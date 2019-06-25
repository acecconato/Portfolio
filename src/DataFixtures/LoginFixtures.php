<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $demoAdmin = new User();
        $demoAdmin
            ->setUsername('demoAdmin')
            ->setPassword($this->passwordEncoder->encodePassword($demoAdmin, 'demo'))
            ->setRoles(['ROLE_ADMIN']);

        $demoUser = new User();
        $demoUser
            ->setUsername('demoUser')
            ->setPassword($this->passwordEncoder->encodePassword($demoUser, 'demo'));

        $manager->persist($demoAdmin);
        $manager->persist($demoUser);
        $manager->flush();
    }
}
