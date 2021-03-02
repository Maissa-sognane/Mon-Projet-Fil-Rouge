<?php

namespace App\DataFixtures;

use App\Entity\Groupe;
use App\Entity\Promo;
use App\Repository\ReferentielRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;

class PromoFixtures extends Fixture
{
    private $userRepository;
    private $referentielRepository;

    public function __construct(UserRepository $userRepository, ReferentielRepository $referentielRepository){
        $this->userRepository = $userRepository;
        $this->referentielRepository = $referentielRepository;
    }
    public function load(ObjectManager $manager)
    {
        $promo=[
            [
                "langue"=>"francais",
                "titre"=>"cohorte 3 dev web/mobile",
                "description"=>"developpeur dev",
                "referenceAgate"=>"dkr ref 2009",
                "lieu"=>"dakar",
                "fabrique"=>"ODC"
            ],
            [
                "langue"=>"francais",
                "titre"=>"cohorte 3 data artisan",
                "description"=>"developpeur en big data",
                "referenceAgate"=>"dkr ref 2009",
                "lieu"=>"dakar",
                "fabrique"=>"ODC"
            ],
            [
                "langue"=>"francais",
                "titre"=>"cohorte 3 Referant digital",
                "description"=>"developpeur stratégie digital",
                "referenceAgate"=>"dkr ref 2009",
                "lieu"=>"dakar",
                "fabrique"=>"ODC"
            ],
        ];

        $groupe=[
            [
                "nom"=>"groupe 1 cohorte 3 dev web/mobile",
                "type"=>"principale C3/dev WEB"
            ],
            [
                "nom"=>"groupe 1 cohorte 3 data artisan",
                "type"=>"principale C3/big data"
            ],
            [
                "nom"=>"groupe 1 cohorte 3 digital",
                "type"=>"principale C3/statégie digitale"
            ]
        ];

        $user = $this->userRepository->findAll();
        $referentiel = $this->referentielRepository->findAll();
        $date = new \DateTime('@'.strtotime('now'));

        foreach ($promo as $key=>$pro){
            $promotion = new Promo();
            foreach ($pro as $value){
                $promotion->setUser($user[0]);
                $promotion->setDescription($pro['description']);
                $promotion->setFabrique($pro['fabrique']);
                $promotion->setLangue($pro['langue']);
                $promotion->setReferenceAgate($pro['referenceAgate']);
                $promotion->setLieu($pro['lieu']);
                $promotion->setDateDebut($date);
                $promotion->setReferentiel($referentiel[0]);
                $promotion->setTitre($pro['titre']);
            }
            foreach ($groupe as$key2=>$grp){
                $grpe = new Groupe();
                foreach ($grp as $val){
                    $grpe->setNom($grp['nom']);
                    $grpe->setType($grp['type']);
                    $grpe->setDateCreation($date);
                }
                $manager->persist($grpe);
                $promotion->addGroupe($grpe);
            }
            $manager->persist($promotion);
        }
        $manager->flush();
    }
}