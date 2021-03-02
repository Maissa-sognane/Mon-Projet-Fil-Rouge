<?php

namespace App\Controller;

use App\Entity\Referentiel;
use App\Repository\GroupeCompetenceRepository;
use App\Repository\ReferentielRepository;
use App\Service\AddReferentiel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ReferentielController extends AbstractController
{
    /**
     * @Route(name="listrefgrpe",
     *   path="api/admin/referentiels/grpecompetences",
     *   methods={"GET"},
     *   defaults={
     *     "_controller"="\app\ControllerReferentielController::showRefGrpe",
     *     "_api_resource_class"=Referentiel::class,
     *     "_api_collection_operation_name"="getrefgrpe",
     *    })
     * @param ReferentielRepository $referentielRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function showRefGrpe(ReferentielRepository $referentielRepository, SerializerInterface $serializer)
    {
       $ref = $referentielRepository->findAll();
       $ref = $serializer->serialize($ref, "json");
       return new JsonResponse($ref, Response::HTTP_OK, [], true);
    }
/*
    /**
     * @Route(name="creationreferentiel",
     *   path="api/admin/referentiels",
     *   methods={"POST"},
     *   defaults={
     *     "_controller"="\app\ControllerReferentielController::creationReferentiel",
     *     "_api_resource_class"=Referentiel::class,
     *     "_api_collection_operation_name"="postreferentiel",
     *    })
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param GroupeCompetenceRepository $groupeCompetenceRepository
     * @param EntityManagerInterface $manager
     * @param ValidatorInterface $validator
     * @param AddReferentiel $addReferentiel
     * @return JsonResponse
     */
/*
    public function creationReferentiel(Request $request, SerializerInterface $serializer,
                                        GroupeCompetenceRepository $groupeCompetenceRepository,
                                        EntityManagerInterface $manager, ValidatorInterface $validator,
                                        AddReferentiel $addReferentiel)
    {
        $referentiel  = $request->getContent();
        $referentielTab = $serializer->decode($referentiel, "json");
        $referentielJSON = $serializer->denormalize($referentielTab, Referentiel::class);
        $referentielObjet= $addReferentiel->serviceAddReferentiel($referentielJSON,$referentielTab,$serializer,
                                            $groupeCompetenceRepository, $manager, $validator);
        return new JsonResponse($referentielObjet, Response::HTTP_CREATED, [], true);
    }
*/
}
