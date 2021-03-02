<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AddReferentiel
{
    public function serviceAddReferentiel($referentielJSON,$referentielTab,$serializer, $groupeCompetenceRepository, $manager, $validator)
    {

        $grpecompetence = $referentielTab['groupeCompetences'];
        foreach ($grpecompetence as $competence){
            $id_grpe = $competence['id'];
            $grpe = $groupeCompetenceRepository->find($id_grpe);
            if(count($competence)===1){
                $referentielJSON->addGroupeCompetence($grpe);
            }
            if (count($competence)===2){
                $referentielJSON->removeGroupeCompetence($grpe);
            }
        }
        $manager->persist($referentielJSON);
        $manager->flush();
        $referentielObjet =  $serializer->serialize($referentielTab, "json");
        return $referentielObjet;
    }
}
