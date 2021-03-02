<?php

namespace App\Controller;


use App\Entity\Competence;
use App\Repository\CompetenceRepository;
use App\Repository\GroupeCompetenceRepository;
use App\Service\AddCompetence;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\JWTUserToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\GroupeCompetence;

class GroupeCompetenceController extends AbstractController
{
    /**
     * @Route(name="creategrpecompetence",
     *   path="api/admin/grpecompetences",
     *   methods={"POST"},
     *   defaults={
     *     "_controller"="\app\ControllerGroupeCompetenceController::createGrpeCompetence",
     *     "_api_resource_class"=GroupeCompetence::class,
     *     "_api_collection_operation_name"="postgrpecompetence",
     *    })
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param UserInterface $user
     * @param CompetenceRepository $competenceRepository
     * @param EntityManagerInterface $manager
     * @param AddCompetence $addCompetence
     * @return JsonResponse
     */
    public function createGrpeCompetence(Request $request, SerializerInterface $serializer, UserInterface $user, CompetenceRepository $competenceRepository,
                                            EntityManagerInterface $manager, AddCompetence $addCompetence)
    {
        $groupecompetence = $request->getContent();
        $groupecompetenceTab = $serializer->decode($groupecompetence, "json");
        $groupecompetenceJSON = $serializer->denormalize($groupecompetenceTab, GroupeCompetence::class);
        $GroupeCompetenceObjet = $addCompetence->serviceAddGroupeCompetence($groupecompetenceJSON,$groupecompetenceTab,$request,
                                                                            $serializer,$user,$competenceRepository, $manager);
        return new JsonResponse($GroupeCompetenceObjet,Response::HTTP_CREATED,[],true);

    }

    /**
     * @Route(name="updategrpecompetence",
     *   path="api/admin/grpecompetence/{id}",
     *   methods={"PUT"},
     *   defaults={
     *     "_controller"="\app\ControllerGroupeCompetenceController::updateGrpeCompetence",
     *     "_api_resource_class"=GroupeCompetence::class,
     *     "_api_item_operation_name"="putgrpecompetence",
     *    })
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param UserInterface $user
     * @param CompetenceRepository $competenceRepository
     * @param EntityManagerInterface $manager
     * @param AddCompetence $addCompetence
     * @param $id
     * @param GroupeCompetenceRepository $groupeCompetence
     * @return JsonResponse
     */

    public function updateGrpeCompetence(Request $request, SerializerInterface $serializer, UserInterface $user, CompetenceRepository $competenceRepository,
                                         EntityManagerInterface $manager, AddCompetence $addCompetence, $id, GroupeCompetenceRepository $groupeCompetence)
    {
        $groupecompetence = $request->getContent();
        $groupecompetenceTab = $serializer->decode($groupecompetence, "json");
        $groupecompetenceJSON = $groupeCompetence->find($id);
        $tab =  $groupecompetenceJSON->getCompetence()->getValues();
        $competences = $groupecompetenceTab['competences'];

        foreach ($tab as $competenceNew){
            if (!(in_array($competenceNew, $competences))){
                $groupecompetenceJSON->removeCompetence($competenceNew);
            }
            else{
                $groupecompetenceJSON->addCompetence($competenceNew);
            }
        }
        foreach ($competences as $comp){
                $id_comp = $comp['id'];
                $competence = $competenceRepository->find($id_comp);
                if($competence){
                    $groupecompetenceJSON->addCompetence($competence);
                }
        }

        $manager->persist($groupecompetenceJSON);
        $manager->flush();
        $grpeCompetenceObjet = $serializer->serialize($groupecompetenceTab, "json");
    //  $GroupeCompetenceObjet = $addCompetence->serviceAddGroupeCompetence($groupecompetenceJSON,$groupecompetenceTab,$request,$serializer,$user,$competenceRepository, $manager);
        return new JsonResponse($grpeCompetenceObjet,Response::HTTP_OK,[],true);
    }
}
