<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Profil;


class ProfilControllers extends AbstractController
{


    /**
     * @Route(
     * name="SauvegarderprofilparId",
     * path="api/admin/profils",
     * methods={"POST"},
     * defaults={
     *     "_controller"="\app\ControllerProfilController::howProfilById",
     *     "_api_resource_class"=Profil::class,
     *     "_api_collectiion_operation_name"="postSaveProfils",
     *    }
     * )
     * @param ProfilRepository $profilRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return JsonResponse
     */

    public function howProfilById(ProfilRepository $profilRepository,  SerializerInterface $serializer,
                                    Request $request, EntityManagerInterface $manager){
    $profils = $request->getContent();
    $profilObjet = $serializer->decode($profils, "json");
    $profilJson = new Profil();
    $profilJson->setLibelle(strtoupper($profilObjet['libelle']));
    $manager->persist($profilJson);
    $manager->flush();
    $profilJson = $serializer->serialize($profilJson, "json");
    return new JsonResponse($profilJson, Response::HTTP_CREATED, [], true);
    }

    /**
     * @Route(
     * name="updateProfil",
     * path="api/admin/profil/{id}",
     * methods={"PUT"},
     * defaults={
     *     "_controller"="\app\ControllerProfilController::updateProfil",
     *     "_api_resource_class"=Profil::class,
     *     "_api_item_operation_name"="putProfil",
     *    }
     * )
     * @param ProfilRepository $profilRepository
     * @param SerializerInterface $serializer
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param $id
     * @return JsonResponse
     */

    function updateProfil(ProfilRepository $profilRepository,  SerializerInterface $serializer,
                          Request $request, EntityManagerInterface $manager, $id)
    {
        $profil = $request->getContent();
        $profil = $serializer->decode($profil, "json");
        $profilData = $profilRepository->find($id);
        $profilData->setLibelle($profil['libelle']);
        $manager->persist($profilData);
        $manager->flush();
        $profilObjet =  $serializer->serialize($profilData, "json");
        return new JsonResponse($profilObjet, Response::HTTP_OK, [], true);
    }
}
