<?php

namespace App\Entity;

use App\Repository\FormateurRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 * @ApiResource(
 *     collectionOperations={
 *       "get"={
 *          "normalization_context"={"groups":"formateurs:read"},
 *          "access_control"="(is_granted('ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     },
 *     "postFormateur"={
 *           "method"="POST",
 *           "route_name"="createFormateur",
 *           "path"="/formateurs",
 *           "deserialize"=false,
 *          "access_control"="(is_granted('ROLE_ADMIN'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     }
 *     },
 *     itemOperations={
 *       "get"={
 *         "path"="formateur/{id}",
 *         "defaults"={"id"=null},
 *         "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *         "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     },
 *     "putFormateur"={
 *          "method"="PUT",
 *          "route_name"="updateFormateur",
 *          "path"="formateur/{id}",
 *          "deserialize"=false,
 *          "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     }
 *
 *     }
 * )
 */
class Formateur extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

 /*   public function getId(): ?int
    {
        return $this->id;
    }
 */
}
