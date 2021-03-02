<?php

namespace App\Entity;

use App\Repository\FormateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @Groups({"promo:read"})
     * @Groups({"user:write"})
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, mappedBy="formateur")
     */
    private $promos;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, mappedBy="formateur")
     */
    private $groupes;

    public function __construct()
    {
        parent::__construct();
        $this->promos = new ArrayCollection();
        $this->groupes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
            $promo->addFormateur($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->removeElement($promo)) {
            $promo->removeFormateur($this);
        }

        return $this;
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
            $groupe->addFormateur($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            $groupe->removeFormateur($this);
        }

        return $this;
    }
}
