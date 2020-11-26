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
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Profil;

class ProfilController extends AbstractController
{


    /**
     * @Route(
     * name="ListerprofilparId",
     * path="api/admin/profils/{id}/users",
     * methods={"GET"},
     * defaults={
     *     "_controller"="\app\ControllerProfilController::showProfilById",
     *     "_api_resource_class"=Profil::class,
     *     "_api_item_operation_name"="getProfilById",
     *    }
     * )
     * @param ProfilRepository $profilRepository
     * @param $id
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */

    public function showProfilById(ProfilRepository $profilRepository, $id, SerializerInterface $serializer){
    $profil = $profilRepository->findOneById($id);
    return $this->json($profil, Response::HTTP_OK);
    }

}
