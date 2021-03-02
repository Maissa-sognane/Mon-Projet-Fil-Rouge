<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\CM;
use App\Entity\Formateur;
use App\Repository\ProfilRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;
use App\Service\AddUser;

class UserController extends AbstractController
{
    /**
     * @Route(
     *      name="saveUser",
     *      path="api/admin/users",
     *      methods={"POST"},
     *      defaults={
     *     "_controller"="\app\ControllerUserController::enregistrerUsers",
     *     "_api_resource_class"=User::class,
     *     "_api_collection_operation_name"="postUser",
     *    }
     * )
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $manager
     * @param ProfilRepository $profilRepository
     * @param UserPasswordEncoderInterface $encoder
     * @param AddUser $addUser
     * @return string
     * @throws ExceptionInterface
     */
    public function enregistrerUsers(Request $request,
                                SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $manager,
                                    ProfilRepository $profilRepository, UserPasswordEncoderInterface $encoder, AddUser $addUser)
    {

        $userJson = $request->request->all();
        if(!is_array($userJson)){
            $userJson = $serializer->encode($userJson, 'json');
        }
        /*
        if(is_array($userJson) === false){
            $userJson = $serializer->decode($userJson, 'json');
        }

        if($userJson === []){
            $userJson = $request->getContent();
            $avatar = $request->files->get("avatar");
            $avatar = fopen($avatar->getRealPath(),"rb");
            $userJson = $serializer->decode($userJson, 'json');
        }
         */

        $profil = explode("/", $userJson["profil"]);
        $profil = $profilRepository->find($profil[3]);
        if(isset($profil)){
            if($profil->getLibelle() === "FORMATEUR" || $profil->getLibelle() === "ADMIN" ||
                $profil->getLibelle() === "CM" || $profil->getLibelle() === "APPRENANT"){
                if($profil->getLibelle() === "FORMATEUR"){
                    $userTab = $serializer->denormalize($userJson, Formateur::class);
                }
                if($profil->getLibelle() === "ADMIN"){
                    $userTab = $serializer->denormalize($userJson, User::class);
                }
                if($profil->getLibelle() === "CM"){
                    $userTab = $serializer->denormalize($userJson, CM::class);
                }
                if($profil->getLibelle() === "APPRENANT"){
                    $userTab = $serializer->denormalize($userJson, Apprenant::class);
                }
                if($request->files->get("avatar") !== null){
                    $avatar = $request->files->get("avatar");
                    $avatar = fopen($avatar->getRealPath(),"rb");
                    $userTab->setAvatar($avatar);
                }
                if($request->files->get("avatar") !== null){
                //    fclose($avatar);
                }
                $addUser->serviceCreateUser($userTab, $userJson,$encoder, $request, $manager, false);
                $userObjet =  $serializer->serialize($userJson, "json");
                return new JsonResponse($userObjet, Response::HTTP_CREATED, [], true);
            }
            else{
                return $this->json("Erreur",Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * @Route(
     *      name="updateUser",
     *      path="api/admin/user/{id}",
     *      methods={"PUT"},
     *      defaults={
     *     "_controller"="\app\ControllerUserController::updateUser",
     *     "_api_resource_class"=User::class,
     *     "_api_item_operation_name"="putUser",
     *    }
     * )
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @param $id
     * @param UserRepository $userRepository
     * @param AddUser $serviceUser
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */

    public function updateUser(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder,
                               $id, UserRepository $userRepository, AddUser $serviceUser, SerializerInterface $serializer){
/*
        if($id !== null){
            $user = $userRepository->find($id);
        }
        else{

        }
*/
       // $userAjouter = $request->request->all();
        $userAjouter = $request->getContent();
        $userAjouter = $serializer->decode($userAjouter, 'json');
        $email = $userAjouter['email'];
        $user = $userRepository->findOneByEmail($email);
       // $isdeleted = $user->getIsdeleted();
      //  dd($user->getIsdeleted());
        if(isset($userAjouter['isdeleted'])){
            $isdeleted = $userAjouter['isdeleted'];
        }else{
            $isdeleted = $user->getIsdeleted();
        }
        $serviceUser->serviceCreateUser($user, $userAjouter, $encoder, $request, $manager, $isdeleted);
        return new JsonResponse("success", Response::HTTP_OK, [], true);
    }

}
