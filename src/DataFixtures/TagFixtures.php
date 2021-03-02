<?php

namespace App\DataFixtures;

use App\Entity\GroupeTag;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class TagFixtures extends Fixture
{

    
    public function load(ObjectManager $manager)
    {

      $tags = [
            [
                "libelle"=>"HTML",
                "descriptif"=>"Concevoir avec HTML"
            ],
            [
                "libelle"=>"Node Js",
                "descriptif"=>"Concevoir avec Node Js"
            ],
            [
                "libelle"=>"Python",
                "descriptif"=>"Concevoir avec Node Python"
            ],
            [
                "libelle"=>"Angular",
                "descriptif"=>"Concevoir avec Node Angular"
            ],
            [
                "libelle"=>"Symfony",
                "descriptif"=>"Concevoir avec Node Symfony"
            ],
            [
                "libelle"=>"API Platforme",
                "descriptif"=>"Concevoir avec Node API Platforme"
            ]
        ];

        $GroupeTag = [
            [
                "libelle"=>"Developpeur Web Mobiile"
            ],
            [
                "libelle"=>"Systéme Réseaux"
            ],
            [
                "libelle"=>"Objet connecté"
            ],
            [
                "libelle"=>"Réferant digital"
            ],
            [
                "libelle"=>"Big Data"
            ],
            [
                "libelle"=>"Analyst Data"
            ]
        ];

        for ($i=0; $i<count($tags); $i++){
            $tag = new Tag();
            $groupetag = new GroupeTag();
            foreach ($tags[$i] as $key=>$value){
                if($key === "libelle"){
                    $tag->setLibelle($value);
                }
                else{
                    $tag->setDescriptif($value);
                }
                $tag->setIsdeleted(false);
             //   $manager->persist($tag);
                $groupetag->setLibelle($GroupeTag[$i]['libelle']);
                $groupetag->addTag($tag);
           //   $manager->persist($groupetag);
            }
         //  $manager->flush();
        }

    }
}
