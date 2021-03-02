<?php

namespace App\Entity;


use App\Repository\GroupeCompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource(
 *     routePrefix="/admin",
 *    collectionOperations={
 *      "get"={
 *          "path"="/grpecompetences",
 *          "normalization_context"={"groups":"grpecompetences:read"},
 *          "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     },
 *      "postgrpecompetence"={
 *          "path"="/grpecompetences",
 *          "method"="POST",
 *          "route_name"="creategrpecompetence",
 *          "denormalization_context"={"groups":"grpecompetences:write"},
 *          "access_control"="(is_granted('ROLE_ADMIN'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *           }
 *     },
 *     itemOperations={
 *        "get"={
 *              "path"="/grpecompetence/{id}",
 *              "normalization_context"={"groups":"grpecompetences:read"},
 *              "requirements"={"id"="\d+"},
 *              "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     },
 *      "delete"={
 *             "path"="/grpecompetence/{id}",
 *     },
 *        "putgrpecompetence"={
 *              "path"="/grpecompetence/{id}",
 *              "route_name"="updatecompetence",
 *              "method"="PUT",
 *              "requirements"={"id"="\d+"},
 *              "denormalization_context"={"groups":"grpecompetences:write"},
 *             "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *             "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     },
 *      " api_groupe_competences_competences_get_subresource"={
 *           "method"="GET",
 *           "path"="/grpecompetence/{id}/competences",
 *           "requirements"={"id"="\d+"},
 *           "normalization_context"={"groups":"grpecompetences:read"},
 *          "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     }
 *     }
 * )
 *  @UniqueEntity(
 *     fields={"libelle"},
 *     errorPath="libelle",
 *     message="libelle existe deja."
 * )
 * @ORM\Entity(repositoryClass=GroupeCompetenceRepository::class)
 *
 */
class GroupeCompetence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"grpecompetences:read", "referentiels:read"})
     * @Groups({"grpecompetences:write", "grpecompetences:read","refgrpecompetence:read", "referentiels:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Champ libelle vide")
     * @Assert\NotNull(message="Champ libelle vide")
     * @Groups({"grpecompetences:write","grpecompetences:read", "referentiels:read", "referentiels:write"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Champ description vide")
     * @Assert\NotNull(message="Champ description vide")
     * @Groups({"grpecompetences:write","grpecompetences:read" ,"referentiels:read", "referentiels:write"})
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"grpecompetences:read"})
     *
     */
    private $isdeleted=false;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="groupeCompetences")
     * @Groups({"grpecompetences:write"})
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, inversedBy="groupeCompetences")
     * @Groups({"grpecompetences:read", "grpecompetences:write"})
     *  @ApiSubresource
     */
    private $competence;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="groupeCompetence")
     */
    private $referentiels;

    public function __construct()
    {
        $this->competence = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsdeleted(): ?bool
    {
        return $this->isdeleted;
    }

    public function setIsdeleted(bool $isdeleted): self
    {
        $this->isdeleted = $isdeleted;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Competence[]
     */
    public function getCompetence(): Collection
    {
        return $this->competence;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competence->contains($competence)) {
            $this->competence[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        $this->competence->removeElement($competence);

        return $this;
    }

    /**
     * @return Collection|Referentiel[]
     */
    public function getReferentiels(): Collection
    {
        return $this->referentiels;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiels->contains($referentiel)) {
            $this->referentiels[] = $referentiel;
            $referentiel->addGroupeCompetence($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiels->removeElement($referentiel)) {
            $referentiel->removeGroupeCompetence($this);
        }

        return $this;
    }
}
