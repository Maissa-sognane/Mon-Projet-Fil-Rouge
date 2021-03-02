<?php

namespace App\DataFixtures;

use App\Entity\Competence;
use App\Entity\GroupeCompetence;
use App\Entity\Niveau;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

class CompetenceFixtures extends Fixture
{
    public $request;
    public $repoUser;

    public function __construct(UserRepository $repoUser){

        $this->repoUser = $repoUser;
    }
    public function load(ObjectManager $manager)
    {
        $competences = [
            [
                "libelle"=>"Dev Web",
                "descriptif"=>"Savoir developper"
            ],
            [
                "libelle"=>"Modele MS",
                "descriptif"=>"conception ssh"
            ],
            [
                "libelle"=>"Symfony",
                "descriptif"=>"Framework PHP"
            ],
            [
                "libelle"=>"Dev Mobile",
                "descriptif"=>"Savoir developper"
            ],
        ];
        $groupeCompetence = [
            [
                "libelle"=>"Telecommunication",
                "description"=>"Telephonie"
            ],
            [
                "libelle"=>"Programme",
                "description"=>"Full"
            ],
            [
                "libelle"=>"Marketing digital",
                "description"=>"commerce"
            ],
            [
                "libelle"=>"DevPHP",
                "description"=>"Back-end"
            ],
        ];
        $niveau=[
            [
                "libelle"=>"Niveau 1",
                "critere_evaluation"=>"Admin pour debutant",
                "groupe_action"=>"à gerer"
            ],
            [
                "libelle"=>"Niveau 2",
                "critere_evaluation"=>"Admis avec Niveau 2",
                "groupe_action"=>"niveau suffisant"
            ],
            [
                "libelle"=>"Niveau 3",
                "critere_evaluation"=>"Admis avec Niveau 3",
                "groupe_action"=>"niveau excellent"
            ],
        ];

        $user = $this->repoUser->findOneBy(["id"=>1]);

        for($i=0; $i<count($competences); $i++){
            $temoin = false;
            $competence = new Competence();
            $groupecompetence = new GroupeCompetence();
            foreach ($competences[$i] as $key=>$comp){
                if($key === "libelle"){
                    $competence->setLibelle($comp);
                }else{
                    $competence->setDescriptif($comp);
                }
            }
            for($j=0; $j<count($niveau); $j++){
                $niveaux = new Niveau();
                $temoin = true;
                foreach ($niveau[$j] as $key_1=>$niv){
                    if($key_1 === "libelle"){
                        $niveaux->setLibelle($niv);
                    }
                    elseif($key_1 === "critere_evaluation"){
                        $niveaux->setCritereEvaluation($niv);
                    }else{
                        $niveaux->setGroupeAction($niv);
                    }
                }
             //   $manager->persist($niveaux);
                $competence->addNiveau($niveaux);
            }
            $groupecompetence->setLibelle($groupeCompetence[$i]["libelle"]);
            $groupecompetence->setDescription($groupeCompetence[$i]['description']);
            $groupecompetence->setUser($user);
            $manager->persist($groupecompetence);
            $competence->addGroupeCompetence($groupecompetence);
       //     $manager->persist($competence);
        }
     //   $manager->flush();
    }
}
