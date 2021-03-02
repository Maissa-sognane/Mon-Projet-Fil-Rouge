<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Elasticsearch\DataProvider\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Elasticsearch\DataProvider\Filter\TermFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(
 *     denormalizationContext={"groups"={"promo_write"}},
 *     routePrefix="/admin",
 *    collectionOperations={
 *      "get"={
 *          "path"="/promo",
 *          "normalization_context"={"groups":"promo:read"},
 *     },
 *     "getListeRef"={
 *          "path"="/promo/principal",
 *          "method"="GET",
 *          "normalization_context"={"groups":"promogrpeprincipal:read"},
 *     },
 *     "getListapprennantattente"={
 *          "path"="/promo/apprenants/attente",
 *          "method"="GET",
 *          "normalization_context"={"groups":"refapprenantattente:read"},
 *     },
 *     "post"={
 *            "path"="/promo"
 *     }
 *     }
 * )
 *
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 * @ApiFilter(SearchFilter::class, properties={"groupes.type": "exact"})
 * @ApiFilter(BooleanFilter::class, properties={"groupes.apprenant.islogging"})
 *
 */
class Promo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"promo:read", "promogrpeprincipal:read", "refapprenantattente:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ langue vide")
     * @Assert\NotNull(message="Champ langue vide")
     * @Groups ({"promo_write"})
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="Champ titre vide")
     * @Assert\NotNull(message="Champ titre vide")
     * @Groups({"promo:read", "promogrpeprincipal:read"})
     * @Groups ({"promo_write"})
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="Champ description vide")
     * @Assert\NotNull(message="Champ description vide")
     * @Groups ({"promo_write"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="Champ lieu vide")
     * @Assert\NotNull(message="Champ lieu vide")
     * @Groups ({"promo_write"})
     */
    private $lieu;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="Champ referenceAgate vide")
     * @Assert\NotNull(message="Champ referenceAgate vide")
     * @Groups ({"promo_write"})
     */
    private $referenceAgate;

    /**
     * @ORM\Column(type="date", nullable=true)
     *
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateProvisoire;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Champ fabrique vide")
     * @Assert\NotBlank(message="Champ fabrique vide")
     * @Groups ({"promo_write"})
     */
    private $fabrique = "Sonatel Academy";

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateFinRelle;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isdeleted=false;

    /**
     * @ORM\Column(type="blob", nullable=true)
     *
     */
    private $avatar;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="promos")
     * @Groups ({"promo_write"})
     *
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="promos")
     * @Groups({"promo:read", "promogrpeprincipal:read"})
     *
     *
     */
    private $formateur;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promo")
     * @Groups({"promogrpeprincipal:read", "refapprenantattente:read"})
     * @Groups ({"promo_write"})
     */
    private $groupes;

    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="promos")
     * @Groups({"promo:read", "promogrpeprincipal:read", "refapprenantattente:read"})
     * @Groups ({"promo_write"})
     */
    private $referentiel;

    public function __construct()
    {
        $this->formateur = new ArrayCollection();
        $this->groupes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getReferenceAgate(): ?string
    {
        return $this->referenceAgate;
    }

    public function setReferenceAgate(string $referenceAgate): self
    {
        $this->referenceAgate = $referenceAgate;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateProvisoire(): ?\DateTimeInterface
    {
        return $this->dateProvisoire;
    }

    public function setDateProvisoire(?\DateTimeInterface $dateProvisoire): self
    {
        $this->dateProvisoire = $dateProvisoire;

        return $this;
    }

    public function getFabrique(): ?string
    {
        return $this->fabrique;
    }

    public function setFabrique(string $fabrique): self
    {
        $this->fabrique = $fabrique;

        return $this;
    }

    public function getDateFinRelle(): ?\DateTimeInterface
    {
        return $this->dateFinRelle;
    }

    public function setDateFinRelle(?\DateTimeInterface $dateFinRelle): self
    {
        $this->dateFinRelle = $dateFinRelle;

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

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

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
     * @return Collection|Formateur[]
     */
    public function getFormateur(): Collection
    {
        return $this->formateur;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateur->contains($formateur)) {
            $this->formateur[] = $formateur;
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        $this->formateur->removeElement($formateur);

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
            $groupe->setPromo($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getPromo() === $this) {
                $groupe->setPromo(null);
            }
        }

        return $this;
    }

    public function getReferentiel(): ?Referentiel
    {
        return $this->referentiel;
    }

    public function setReferentiel(?Referentiel $referentiel): self
    {
        $this->referentiel = $referentiel;

        return $this;
    }
}
