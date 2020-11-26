<?php


namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Profil;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfilFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public const ADMIN_REFERENCE = "ADMIN";
    public const FORMATEUR_REFERENCE = "FORMATEUR";
    public const APPRENANT_REFERENCE = "APPRENANT";
    public const CM_REFERENCE = "CM";

    public function load(ObjectManager $manager)
    {

        $profil = new Profil();
        $profil->setLibelle(self::ADMIN_REFERENCE);
        $profil->setIsdeleted(false);
     //   $manager->persist($profil);
        $this->addReference(self::ADMIN_REFERENCE, $profil);

        $profil_Formateur = new Profil();
        $profil_Formateur->setLibelle(self::FORMATEUR_REFERENCE);
        $profil_Formateur->setIsdeleted(false);
       // $manager->persist($profil_Formateur);
        $this->addReference(self::FORMATEUR_REFERENCE, $profil_Formateur);

        $profil_Apprenant = new Profil();
        $profil_Apprenant->setLibelle(self::APPRENANT_REFERENCE);
        $profil_Apprenant->setIsdeleted(false);
      //  $manager->persist($profil_Apprenant);
        $this->addReference(self::APPRENANT_REFERENCE, $profil_Apprenant);

        $profil_CM = new Profil();
        $profil_CM->setLibelle(self::CM_REFERENCE);
        $profil_CM->setIsdeleted(false);
      //  $manager->persist($profil_CM);
        $this->addReference(self::CM_REFERENCE, $profil_CM);

       // $manager->flush();
    }

}
