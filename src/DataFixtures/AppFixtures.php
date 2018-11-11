<?php

namespace App\DataFixtures;

use App\Entity\Passanger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Customer;

class AppFixtures extends Fixture
{
    private $enconder;

    /**
     * UserFicture constructor.
     * @param UserPasswordEncoderInterface $enconder
     */
    public function __construct(UserPasswordEncoderInterface $enconder)
    {
        $this->enconder = $enconder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new Customer();
        $user->setEmail('test@gmail.com')
            ->setPassword(
                $this->enconder->encodePassword($user, 'option')
            )
            ->setName('Rei')
            ->setAddress('Chitty Street')
            ->setCountry('United Kingdo`m')
            ->setCity('London');

        $passanger = new Passanger();
        $passanger->setTitle('Mr')
            ->setName('Rei')
            ->setSurname('Ziedins')
            ->setPassportId('1337');
        $manager->persist($user);
        $manager->persist($passanger);
        $manager->flush();
    }
}
