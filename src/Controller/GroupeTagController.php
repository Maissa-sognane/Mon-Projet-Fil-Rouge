<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Tag;
use App\Repository\GroupeTagRepository;
use App\Repository\TagRepository;
use App\Service\AddGroupeTag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\GroupeTag;



class GroupeTagController extends AbstractController
{

    /**
     * @Route(name="creategrptag",
     *   path="api/admin/grptags",
     *   methods={"POST"},
     *   defaults={
     *     "_controller"="\app\ControllerGroupeTagController::createGrpTag",
     *     "_api_resource_class"=GroupeTag::class,
     *     "_api_collection_operation_name"="postgrpetag",
     *    }
     * )
     * @param GroupeTagRepository $repository
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $manager
     * @param TagRepository $repotag
     * @param AddGroupeTag $addGroupeTag
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */

    public function createGrpTag(GroupeTagRepository $repository, Request $request, SerializerInterface $serializer,
                                 EntityManagerInterface $manager, TagRepository $repotag, AddGroupeTag $addGroupeTag, ValidatorInterface $validator)
    {
        $groupetag = $request->getContent();
        $grpetagTab = $serializer->decode($groupetag, "json");
        $data =  $serializer->deserialize($groupetag, GroupeTag::class, "json");
        $GroupeTag = $addGroupeTag->serviceCreateGrpTag($data,$grpetagTab ,$serializer,  $manager,  $repotag,$validator);
        /*
        $groupetag = $request->getContent();
        $grpetagTab = $serializer->decode($groupetag, "json");
        $grpetagJson = $serializer->deserialize($groupetag, GroupeTag::class, "json");
        $errors = $validator->validate($grpetagJson);
        if ($errors!==null && ($errors) > 0){
            $errorsString =$serializer->serialize($errors,"json");
            return new JsonResponse( $errorsString ,Response::HTTP_BAD_REQUEST,[],true);
        }
        foreach ($grpetagTab['tags'] as $grptag){
            if(count($grptag) === 1){
                $id = $grptag["id"];
                $Tags = $repotag->find($id);
                $grpetagJson->addTag($Tags);
            }
            if(count($grptag) === 2){
                if(isset($grptag['id'])){
                    $id = $grptag["id"];
                    $Tags = $repotag->find($id);
                    $grpetagJson->removeTag($Tags);
                }else{
                    $Tags = new Tag();
                    $Tags->setLibelle($grptag['libelle']);
                    $Tags->setDescriptif($grptag['descriptif']);
                    $manager->persist($Tags);
                    $grpetagJson->addTag($Tags);
                }
            }
        }
            $manager->persist($grpetagJson);
            $manager->flush();
        */
      //  dd($GroupeTag->getTag());
       // return new JsonResponse($GroupeTag,Response::HTTP_CREATED,[],true);
        $GroupeJson = $serializer->serialize($grpetagTab, "json");
        return new JsonResponse($GroupeJson,Response::HTTP_CREATED,[],true);
    }


    /**
     * @Route(name="updategrptag",
     *   path="api/admin/grptag/{id}",
     *   methods={"PUT"},
     *   defaults={
     *     "_controller"="\app\ControllerGroupeTagController::updateGrpTag",
     *     "_api_resource_class"=GroupeTag::class,
     *     "_api_item_operation_name"="putgrpetag",
     *    }
     * )
     * @param GroupeTagRepository $repository
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $manager
     * @param $id
     * @param TagRepository $repotag
     * @param AddGroupeTag $addGroupeTag
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */

    public function updateGrpTag(GroupeTagRepository $repository, Request $request, SerializerInterface $serializer,
                                 EntityManagerInterface $manager, $id, TagRepository $repotag, AddGroupeTag $addGroupeTag, ValidatorInterface $validator)
    {
        $grpetag = $request->getContent();
        $grpetag = $serializer->decode($grpetag, "json");
        $data = $repository->find($id);
        $GroupeTag = $addGroupeTag->serviceCreateGrpTag($data,$grpetag ,$serializer,  $manager,  $repotag,$validator);
        $GroupeJson = $serializer->serialize($GroupeTag, "json");
        return new JsonResponse($GroupeJson,Response::HTTP_OK,[],true);
    }
}