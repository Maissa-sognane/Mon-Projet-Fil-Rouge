<?php

namespace App\DataFixtures;

use App\Entity\Formateur;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class FormateurFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $formateur = new Formateur();
        $formateur->setPrenom("Baila");
        $formateur->setNom("Wana");
        $formateur->setEmail("baila@gmail.com");
        $formateur->setIsdeleted(false);
        $password = $this->encoder->encodePassword($formateur, "passer");
        $formateur->setPassword($password);
        $formateur->setProfil($this->getReference(ProfilFixtures::FORMATEUR_REFERENCE));
    //    $manager->persist($formateur);
     //   $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ProfilFixtures::class,
        );
    }
}
