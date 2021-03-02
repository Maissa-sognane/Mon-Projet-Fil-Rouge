<?php

namespace App\DataFixtures;

use App\Entity\Referentiel;
use App\Repository\CompetenceRepository;
use App\Repository\GroupeCompetenceRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

class ReferentielFixtures extends Fixture
{

    private $competenceRepository;

    public function __construct(GroupeCompetenceRepository $competenceRepository){
        $this->competenceRepository = $competenceRepository;
    }

    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.

        $referentiels = [
            [
                "libelle"=>"Referentiel dev Web/Mobile",
                "presentation"=>"une formation developpement",
                "programme"=>"Symfony, Angular, Flutter",
                "critereEvaluation"=>"critere1;critere2",
                "critereAdmission"=>"admission1; admission2",

            ],
            [
                "libelle"=>"Referentiel  referant digital",
                "presentation"=>"une formation digital",
                "programme"=>"digital, marketing",
                "critereEvaluation"=>"critere3;critere4",
                "critereAdmission"=>"admission3; admission4",

            ],
            [
                "libelle"=>"Referentiel Data Artisan",
                "presentation"=>"une formation data analyst",
                "programme"=>"Python, statistique",
                "critereEvaluation"=>"critere5;critere6",
                "critereAdmission"=>"admission5; admission6",

            ],
            [
                "libelle"=>"Referentiel I.A",
                "presentation"=>"une formation inteligeance Artificielle",
                "programme"=>"Python, mathématique, R",
                "critereEvaluation"=>"critere7;critere8",
                "critereAdmission"=>"admission7; admission8",
            ],
        ];

        $grpeCompetence = $this->competenceRepository->findAll();
        foreach ($referentiels as $key=>$referentiel){
            $ref = new Referentiel();
            foreach ($referentiel as $value){
                $ref->setLibelle($referentiel['libelle']);
                $ref->setCritereEvaluation($referentiel['critereEvaluation']);
                $ref->setCritereAdmission($referentiel['critereAdmission']);
                $ref->setProgramme($referentiel['programme']);
                $ref->setPresentation($referentiel['presentation']);
                $ref->addGroupeCompetence($grpeCompetence[$key]);
              //  $manager->persist($ref);
            }
        }
      //  $manager->flush();

    }
}
