<?php

namespace App\Entity;

use App\Repository\ApprenantRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 * @ApiResource(
 *     collectionOperations={
 *      "getApprenant"={
 *          "path"="/apprenants",
 *          "method"="GET",
 *          "route_name"="ReadApprenant",
 *          "normalization_context"={"groups":"apprenant:read"},
 *          "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     },
 *     "postApprenant"={
 *          "route_name"="createApprenant",
 *          "method"="POST",
 *          "path"="/apprenants",
 *          "deserialize"=false,
 *          "access_control"="(is_granted('ROLE_ADMIN'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     },
 *     },
 *     itemOperations={
 *       "get"={
 *         "path"="apprenants/{id}",
 *         "defaults"={"id"=null},
 *         "access_control"="(is_granted('ROLE_APPRENANT'))",
 *         "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     },
 *     "putApprenant"={
 *          "route_name"="UpdateApprenant",
 *          "path"="/apprenant/{id}",
 *          "method"="PUT",
 *          "deserialize"=false,
 *     },
 *     "delete"={
 *          "path"="/apprenant/{id}",
 *          "access_control"="(is_granted('ROLE_ADMIN'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     }
 *     }
 * )
 */
class Apprenant extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     */

    private $id;


    public function getId(): ?int
    {
        return $this->id;
    }

}
