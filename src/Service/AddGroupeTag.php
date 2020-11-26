<?php

namespace App\Service;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\GroupeTag;
use App\Entity\Tag;
use App\Repository\GroupeTagRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class AddGroupeTag
{
    public function serviceCreateGrpTag($data,$grpetagTab,$serializer,$manager,$repotag,$validator)
    {
        $errors = $validator->validate($data);
        if ($errors!==null && ($errors) > 0){
            $errorsString =$serializer->serialize($errors,"json");
            return new JsonResponse( $errorsString ,Response::HTTP_BAD_REQUEST,[],true);
        }
        foreach ($grpetagTab['tags'] as $grptag){
            if(count($grptag) === 1){
                $id = $grptag["id"];
                $Tags = $repotag->find($id);
                $data->addTag($Tags);
            }
            if(count($grptag) === 2){
                if(isset($grptag['id'])){
                    $id = $grptag["id"];
                    $Tags = $repotag->find($id);
                    $data->removeTag($Tags);
                }else{
                    $Tags = new Tag();
                    $Tags->setLibelle($grptag['libelle']);
                    $Tags->setDescriptif($grptag['descriptif']);
                    $manager->persist($Tags);
                    $data->addTag($Tags);
                }
            }
        }
        $manager->persist($data);
        $manager->flush();
        return $data;
    }
}