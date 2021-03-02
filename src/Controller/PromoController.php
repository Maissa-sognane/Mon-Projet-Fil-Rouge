<?php

namespace App\Controller;

use App\Repository\ApprenantRepository;
use App\Repository\ReferentielRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;
use Symfony\Component\Serializer\SerializerInterface;

class PromoController extends AbstractController
{
    /**
     * @Route(name="createpromo",
     *   path="api/admin/promotion",
     *   methods={"PUT"},
     *   defaults={
     *     "_controller"="\app\ControllerPromoController::createPromo",
     *     "_api_resource_class"=Promo::class,
     *     "_api_collection_operation_name"="postpromo",
     *    }
     * )
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $manager
     * @param ReferentielRepository $referentielRepository
     * @param UserInterface $user
     * @param ApprenantRepository $apprenantRepository
     * @param UserPasswordEncoderInterface $encoder
     * @param \Swift_Mailer $mailer
     */
    public function createPromo(Request $request, SerializerInterface $serializer,
                            EntityManagerInterface $manager,ReferentielRepository $referentielRepository,
                        UserInterface $user, ApprenantRepository $apprenantRepository, UserPasswordEncoderInterface $encoder,
                    \Swift_Mailer $mailer)
    {

    }
}
