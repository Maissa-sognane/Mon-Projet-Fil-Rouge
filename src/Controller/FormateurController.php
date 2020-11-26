<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\Formateur;
use App\Repository\FormateurRepository;
use App\Service\AddUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class FormateurController extends AbstractController
{
    /**
     * @Route(
     *      name="createFormateur",
     *      path="api/formateurs",
     *      methods={"POST"},
     *      defaults={
     *     "_controller"="\app\ControllerApprenantController::createFormateur",
     *     "_api_resource_class"=Formateur::class,
     *     "_api_collection_operation_name"="postFormateur",
     *    }
     *)
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @param AddUser $addUser
     * @return JsonResponse
     */

    public function createFormateur(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager,
                                    UserPasswordEncoderInterface $encoder, AddUser $addUser){

        $formateurTab = $request->request->all();
        $formateurJson = $serializer->denormalize($formateurTab, Formateur::class);
        $formateurJson->setIsdeleted(false);
        $addUser->serviceCreateUser($formateurJson, $formateurTab,$encoder, $request, $manager, false);
        return new JsonResponse("success", Response::HTTP_OK, [], true);
    }

    /**
     * @Route(
     *      name="updateFormateur",
     *      path="api/formateur/{id}",
     *      methods={"PUT"},
     *      defaults={
     *     "_controller"="\app\ControllerApprenantController::updateFormateur",
     *     "_api_resource_class"=Formateur::class,
     *     "_api_item_operation_name"="putFormateur",
     *    }
     *)
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @param AddUser $addUser
     * @param $id
     * @param FormateurRepository $formateurRepository
     * @return JsonResponse
     */

    public function updateFormateur(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager,
                                    UserPasswordEncoderInterface $encoder,
                                    AddUser $addUser, $id, FormateurRepository $formateurRepository){
        $formateurTab = $request->request->all();
        $formateurJson = $formateurRepository->find($id);
        if(isset($formateurTab['isdeleted'])){
            $isdeleted = $formateurTab['isdeleted'];
        }
        else{
            $isdeleted = $formateurJson->getIsdeleted();
        }
        $addUser->serviceCreateUser($formateurJson, $formateurTab,$encoder, $request, $manager, $isdeleted);
        return $this->json($formateurJson, Response::HTTP_OK);
    }

}
