<?php

namespace App\Service;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Competence;
use App\Entity\GroupeTag;
use App\Entity\Niveau;
use App\Entity\Tag;
use App\Repository\CompetenceRepository;
use App\Repository\GroupeTagRepository;
use App\Repository\NiveauRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class AddCompetence
{
    public function serviceAddCompetence($competenceJson, $competenceTab,$serializer,$validator, $niveauRepository,
                                         $manager, $niveau=null)
    {
        $errors = $validator->validate($competenceJson);
        if ($errors!==null && ($errors) > 0){
            $errorsString =$serializer->serialize($errors,"json");
            return new JsonResponse( $errorsString ,Response::HTTP_BAD_REQUEST,[],true);
        }
        $niveaux = $competenceTab['niveaux'];
        $temoin = false;
        foreach ($niveaux as $niv){
            $libelle = $niv['libelle'];
            $critereEvaluation = $niv['critereEvaluation'];
            $groupeAction = $niv['groupeAction'];
            if(count($niv) === 3){
                $niveau = new Niveau();
                $niveau->setLibelle($libelle);
                $niveau->setCritereEvaluation($critereEvaluation);
                $niveau->setGroupeAction($groupeAction);
            }
            if(count($niv) === 4){
                $id_niveau = $niv['id'];
                $niveau = $niveauRepository->find($id_niveau);
                $niveau->setCompetence($competenceJson);
                $competenceJson->removeNiveau($niveau);
                $niveau->setLIbelle($libelle);
                $niveau->setCritereEvaluation($critereEvaluation);
                $niveau->setGroupeAction($groupeAction);
            }
        }
        $manager->persist($competenceJson);
        $manager->flush();
        $competenceObjet = $serializer->serialize($competenceTab, "json");
        return $competenceObjet;

    }

    public function serviceAddGroupeCompetence($groupecompetenceJSON,$groupecompetenceTab,$request,$serializer,$user,$competenceRepository, $manager)
    {
        $groupecompetenceJSON->setUser($user);
        $competences = $groupecompetenceTab['competences'];
        foreach ($competences as $comp){
            if(is_object($comp)){
                $id_comp = $comp['id'];
                $competence = $competenceRepository->find($id_comp);
                if($groupecompetenceJSON->getCompetence()->getValues()){
                    $tabGrpeCompetence = $groupecompetenceJSON->getCompetence()->getValues();
                    foreach ($tabGrpeCompetence as $grpe){
                        if($grpe->getId() !== $competence->getId()){
                            $groupecompetenceJSON->removeCompetence($grpe);
                        }
                    }
                }
                $groupecompetenceJSON->addCompetence($competence);
            }
            if(is_array($comp)){
                if(count($comp) >= 2){
                    $id_comp = $comp['id'];
                    $competence = $competenceRepository->find($id_comp);
                    $groupecompetenceJSON->addCompetence($competence);
                }
                if(count($comp) === 1){
                    $newCompetence = new Competence();
                    $newCompetence->setLibelle($comp['libelle']);
                    $newCompetence->setIsdeleted(false);
                    $newCompetence->setDescriptif('Descreption competence');
                    $manager->persist($newCompetence);
                    $groupecompetenceJSON->addCompetence($newCompetence);
                    //  $groupecompetenceJSON->removeCompetence($competence);
                }
            }
        }
          $manager->persist($groupecompetenceJSON);
          $manager->flush();

        $grpeCompetenceObjet = $serializer->serialize($groupecompetenceTab, "json");
        return $grpeCompetenceObjet;
    }
}
