<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ReferentielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource(
 *     routePrefix="/admin",
 *     collectionOperations={
 *       "get"={
 *           "path"="/referentiels",
 *           "normalization_context"={"groups":"referentiels:read"},
 *          "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     },
 *       "getrefgrpe"={
 *           "path"="/referentiels/grpecompetences",
 *           "method"="GET",
 *           "route_name"="listrefgrpe",
 *           "normalization_context"={"groups":"refgrpecompetence:read"},
 *          "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     },
 *     "post"={
 *          "path"="/referentiels",
 *          "denormalization_context"={"groups":"referentiels:write"},
 *          "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     }
 *     },
 *     itemOperations={
 *       "get"={
 *          "path"="/referentiel/{id}",
 *          "normalization_context"={"groups":"referentiels:read"},
 *          "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM') or is_granted('ROLE_APPRENANT'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     },
 *       "api_referentiels_groupe_competences_competences_get_subresource"={
 *            "method"="GET",
 *            "path"="/referentiel/{id}/grpecompetence/{groupeCompetence}",
 *            "normalization_context"={"groups":"referentiels:read"},
 *            "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM') or is_granted('ROLE_APPRENANT'))",
 *            "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     },
 *     "put"={
 *
 *          "path"="/referentiel/{id}",
 *          "denormalization_context"={"groups":"referentiels:write"},
 *          "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     },
 *     "delete"={
 *          "path"="/referentiel/{id}",
 *          "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource"
 *     }
 *     }
 * )
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 * * @UniqueEntity(
 *     fields={"libelle"},
 *     errorPath="libelle",
 *     message="libelle existe deja."
 * )
 */
class Referentiel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"referentiels:read", "refgrpecompetence:read", "promo:read", "promogrpeprincipal:read"})
     * @Groups ({"promo_write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ libelle vide")
     * @Assert\NotNull(message="Champ libelle vide")
     * @Groups({"referentiels:read", "referentiels:write", "promo:read", "promogrpeprincipal:read"})
     * @Groups ({"refapprenantattente:read"})
     *
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ presentation vide")
     * @Assert\NotNull(message="Champ presentation vide")
     * @Groups({"referentiels:read", "referentiels:write"})
     */
    private $presentation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ programme vide")
     * @Assert\NotNull(message="Champ programme vide")
     * @Groups({"referentiels:read", "referentiels:write"})
     */
    private $programme;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ critere evaluation vide")
     * @Assert\NotNull(message="Champ critere evaluation vide")
     * @Groups({"referentiels:read", "referentiels:write"})
     */
    private $critereEvaluation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ critere admission vide")
     * @Assert\NotNull(message="Champ critere admission vide")
     * @Groups({"referentiels:read", "referentiels:write"})
     */
    private $critereAdmission;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isdeleted=false;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, inversedBy="referentiels")
     * @Groups({"referentiels:read", "refgrpecompetence:read", "referentiels:write"})
     * @ApiSubresource
     */
    private $groupeCompetence;

    /**
     * @ORM\OneToMany(targetEntity=Promo::class, mappedBy="referentiel")
     */
    private $promos;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"referentiels:read"})
     */
    private $FichierProgramme;


    public function __construct()
    {
        $this->groupeCompetence = new ArrayCollection();
        $this->user = new ArrayCollection();
        $this->promos = new ArrayCollection();
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

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getProgramme(): ?string
    {
        return $this->programme;
    }

    public function setProgramme(string $programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    public function getCritereEvaluation(): ?string
    {
        return $this->critereEvaluation;
    }

    public function setCritereEvaluation(string $critereEvaluation): self
    {
        $this->critereEvaluation = $critereEvaluation;

        return $this;
    }

    public function getCritereAdmission(): ?string
    {
        return $this->critereAdmission;
    }

    public function setCritereAdmission(string $critereAdmission): self
    {
        $this->critereAdmission = $critereAdmission;

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
     * @return Collection|GroupeCompetence[]
     */
    public function getGroupeCompetence(): Collection
    {
        return $this->groupeCompetence;
    }

    public function addGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if (!$this->groupeCompetence->contains($groupeCompetence)) {
            $this->groupeCompetence[] = $groupeCompetence;
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        $this->groupeCompetence->removeElement($groupeCompetence);

        return $this;
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
            $promo->setReferentiel($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->removeElement($promo)) {
            // set the owning side to null (unless already changed)
            if ($promo->getReferentiel() === $this) {
                $promo->setReferentiel(null);
            }
        }

        return $this;
    }

    public function getFichierProgramme()
    {
        if($this->FichierProgramme){
            $this->FichierProgramme = stream_get_contents($this->FichierProgramme);
            $g=base64_encode($this->FichierProgramme);
            return $g;
        }
        return null;
    }

    public function setFichierProgramme($FichierProgramme): self
    {
        $this->FichierProgramme = $FichierProgramme;

        return $this;
    }



}
