<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Niveau;
use App\Repository\CompetenceRepository;
use App\Repository\NiveauRepository;
use App\Service\AddCompetence;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Competence;
use Symfony\Component\Serializer\SerializerInterface;

class CompetenceController extends AbstractController
{
    /**
     * @Route(name="createcompetence",
     *   path="api/admin/competences",
     *   methods={"POST"},
     *   defaults={
     *     "_controller"="\app\ControllerCompetenceController::createCompetence",
     *     "_api_resource_class"=Competence::class,
     *     "_api_collection_operation_name"="postcreate",
     *    }
     * )
     * @param AddCompetence $addCompetence
     * @param EntityManagerInterface $manager
     * @param ValidatorInterface $validator
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param NiveauRepository $niveauRepository
     * @param CompetenceRepository $competenceRepository
     * @return JsonResponse
     */

    public function createCompetence(AddCompetence $addCompetence, EntityManagerInterface $manager,
                                        ValidatorInterface $validator, Request $request,
                                        SerializerInterface $serializer, NiveauRepository $niveauRepository,
                                        CompetenceRepository $competenceRepository)
    {
        $competence = $request->getContent();
        $competenceTab = $serializer->decode($competence, "json");
        $competenceJson = $serializer->denormalize($competenceTab, Competence::class);
        $competenceObjet = $addCompetence->serviceAddCompetence($competenceJson,$competenceTab, $serializer,$validator, $niveauRepository,
            $manager);
        return new JsonResponse($competenceObjet,Response::HTTP_CREATED,[],true);
    }

    /**
     * @Route(name="updatecompetence",
     *   path="api/admin/competence/{id}",
     *   methods={"PUT"},
     *   defaults={
     *     "_controller"="\app\ControllerCompetenceController::updateCompetence",
     *     "_api_resource_class"=Competence::class,
     *     "_api_item_operation_name"="putcompetence",
     *    }
     * )
     * @param AddCompetence $addCompetence
     * @param EntityManagerInterface $manager
     * @param ValidatorInterface $validator
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param NiveauRepository $niveauRepository
     * @param CompetenceRepository $competenceRepository
     * @param $id
     * @return JsonResponse
     */

    public function updateCompetence(AddCompetence $addCompetence, EntityManagerInterface $manager,
                                     ValidatorInterface $validator, Request $request,
                                     SerializerInterface $serializer, NiveauRepository $niveauRepository,
                                     CompetenceRepository $competenceRepository, $id)
    {
        $competence = $request->getContent();
        $competenceTab = $serializer->decode($competence, "json");
        $competenceJson = $competenceRepository->find($id);
        $niveauTab = $competenceJson->getNiveaux()->getValues();
        foreach ($niveauTab as $niv){
            $competenceJson->removeNiveau($niv);
        }
        $competenceObjet = $addCompetence->serviceAddCompetence($competenceJson,$competenceTab, $serializer,$validator, $niveauRepository,$manager);
        return new JsonResponse($competenceObjet,Response::HTTP_OK,[],true);
    }

}
