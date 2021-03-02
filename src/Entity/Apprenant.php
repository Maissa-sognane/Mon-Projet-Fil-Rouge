<?php

namespace App\Entity;

use App\Repository\ApprenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
 *          "defaults"={"id"=null},
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
     *
     */

    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, mappedBy="apprenant")
     */
    private $groupes;

    public function __construct()
    {
        parent::__construct();
        $this->groupes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->addApprenant($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            $groupe->removeApprenant($this);
        }

        return $this;
    }

}
