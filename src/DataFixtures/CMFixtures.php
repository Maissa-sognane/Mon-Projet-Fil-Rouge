<?php

namespace App\DataFixtures;

use App\Entity\CM;
use App\Entity\Formateur;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CMFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $cm = new CM();
        $cm->setPrenom("yankoba");
        $cm->setNom("CM");
        $cm->setEmail("cm@gmail.com");
        $cm->setIsdeleted(false);
        $password = $this->encoder->encodePassword($cm, "passer");
        $cm->setPassword($password);
        $cm->setProfil($this->getReference(ProfilFixtures::CM_REFERENCE));
     //   $manager->persist($cm);
     //   $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ProfilFixtures::class,
        );
    }

}
