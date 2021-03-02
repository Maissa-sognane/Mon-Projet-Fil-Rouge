<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     routePrefix="/admin",
 *     collectionOperations={
 *      "get"={
 *          "path"="/competences",
 *          "normalization_context"={"groups":"competences:read"},
 *          "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     },
 *     "postcreate"={
 *          "path"="/competences",
 *          "method"="POST",
 *          "route_name"="createcompetence",
 *          "access_control"="(is_granted('ROLE_ADMIN'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *
 *     }
 *     },
 *     itemOperations={
 *       "get"={
 *          "path"="/competence/{id}",
 *          "normalization_context"={"groups":"competences:read"},
 *          "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     },
 *     "putcompetence"={
 *          "path"="/competence/{id}",
 *          "method"="PUT",
 *          "route_name"="updatecompetence",
 *          "access_control"="(is_granted('ROLE_ADMIN'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     },
 *     "delete"={
 *          "path"="/competence/{id}",
 *          "access_control"="(is_granted('ROLE_ADMIN'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     }
 *     }
 * )
 * @UniqueEntity(
 *     fields={"libelle"},
 *     errorPath="libelle",
 *     message="libelle existe deja."
 * )
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 */
class Competence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"competences:read", "grpecompetences:read", "grpecompetences:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Champ libelle vide")
     * @Assert\NotNull(message="Champ libelle vide")
     * @Groups({"grpecompetences:read", "competences:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ descriptif vide")
     * @Assert\NotNull(message="Champ descriptif vide")
     *  @Groups({"grpecompetences:read"})
     */
    private $descriptif;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isdeleted=false;

    /**
     * @ORM\OneToMany(targetEntity=Niveau::class, mappedBy="competence", cascade={"persist"})
     * @Groups({"competences:read",  "grpecompetences:read"})
     */
    private $niveaux;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, mappedBy="competence")
     */
    private $groupeCompetences;

    public function __construct()
    {
        $this->niveaux = new ArrayCollection();
        $this->groupeCompetences = new ArrayCollection();
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

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(string $descriptif): self
    {
        $this->descriptif = $descriptif;

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

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux[] = $niveau;
            $niveau->setCompetence($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->removeElement($niveau)) {
            // set the owning side to null (unless already changed)
            if ($niveau->getCompetence() === $this) {
                $niveau->setCompetence(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|GroupeCompetence[]
     */
    public function getGroupeCompetences(): Collection
    {
        return $this->groupeCompetences;
    }

    public function addGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if (!$this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences[] = $groupeCompetence;
            $groupeCompetence->addCompetence($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if ($this->groupeCompetences->removeElement($groupeCompetence)) {
            $groupeCompetence->removeCompetence($this);
        }

        return $this;
    }
}
