<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\Formateur;
use App\Repository\ApprenantRepository;
use App\Repository\ProfilRepository;
use App\Service\AddUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApprenantController extends AbstractController
{

    /**
     * @Route(name="ReadApprenant",
     *   path="api/apprenants",
     *   methods={"GET"},
     *   defaults={
     *     "_controller"="\app\ControllerApprenantController::showApprenant",
     *     "_api_resource_class"=Apprenant::class,
     *     "_api_collection_operation_name"="getApprenant",
     *    }
     * )
     * @param ApprenantRepository $repository
     * @param AddUser $addUser
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function showApprenant(ApprenantRepository $repository, AddUser $addUser, SerializerInterface $serializer)
    {
        $apprenants = $addUser->serviceReadUser($repository);
/*
        $apprenants = $serializer->serialize($apprenants,"json");
        return new JsonResponse($apprenants,Response::HTTP_OK,[],true);
*/
        return $this->json($apprenants, Response::HTTP_OK);
    }
    /**
     * @Route(
     *      name="createApprenant",
     *      path="api/apprenants",
     *      methods={"POST"},
     *      defaults={
     *     "_controller"="\app\ControllerApprenantController::createApprenant",
     *     "_api_resource_class"=Apprenant::class,
     *     "_api_collection_operation_name"="postApprenant",
     *    }
     *)
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @param AddUser $addUser
     * @return JsonResponse
     */

    public function createApprenant(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager,
                                     UserPasswordEncoderInterface $encoder, AddUser $addUser){
        $apprenantsTab = $request->request->all();
        $apprenantsJson = $serializer->denormalize($apprenantsTab, Apprenant::class);
        $apprenantsJson->setIsdeleted(false);
        $addUser->serviceCreateUser($apprenantsJson, $apprenantsTab,$encoder, $request, $manager, false);
        return new JsonResponse("success", Response::HTTP_OK, [], true);
    }

    /**
     * @Route(
     *      name="UpdateApprenant",
     *      path="api/apprenant/{id}",
     *      methods={"PUT"},
     *      defaults={
     *     "_controller"="\app\ControllerApprenantController::updateApprenant",
     *     "_api_resource_class"=Apprenant::class,
     *     "_api_item_operation_name"="putApprenant",
     *    }
     *)
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @param AddUser $addUser
     * @param $id
     * @param ApprenantRepository $apprenantRepository
     * @return JsonResponse
     */

    public function updateApprenant(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager,
                                    UserPasswordEncoderInterface $encoder, AddUser $addUser, $id, ApprenantRepository $apprenantRepository){
        $apprenanttab = $request->request->all();
        $apprenantJson = $apprenantRepository->find($id);
        if(isset($apprenanttab['isdeleted'])){
            $isdeleted = $apprenanttab['isdeleted'];
        }else{
            $isdeleted = $apprenantJson->getIsdeleted();
        }
        $addUser->serviceCreateUser($apprenantJson, $apprenanttab,$encoder, $request, $manager, $isdeleted);
        return new JsonResponse("success", Response::HTTP_OK, [], true);
    }

}
