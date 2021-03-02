<?php

namespace App\DataFixtures;

use App\Entity\Apprenant;
use App\Entity\Formateur;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ApprenantFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $Apprenant = new Apprenant();
        $Apprenant->setPrenom("Penda");
        $Apprenant->setNom("Diallo");
        $Apprenant->setEmail("penda@gmail.com");
        $Apprenant->setIsdeleted(false);
        $password = $this->encoder->encodePassword($Apprenant, "passer");
        $Apprenant->setPassword($password);
        $Apprenant->setProfil($this->getReference(ProfilFixtures::APPRENANT_REFERENCE));
       // $manager->persist($Apprenant);
        //$manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ProfilFixtures::class,
        );
    }

}
