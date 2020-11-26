<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 * @ApiResource (
 *     routePrefix="/admin",
 *  attributes={
 *          "security"="is_granted('ROLE_FORMATEUR')",
 *          "security_message"="Vous n'avez pas l'acces aux ressources"
 *      },
 *    collectionOperations={
 *      "get"={
 *       "path"="/tags"
 *     },
 *     "post"={
 *       "path"="/tags"
 *     }
 *     },
 *  itemOperations={
 *      "get"={
 *          "path"="/tag/{id}"
 *     },
 *     "put"={
 *          "path"="/tag/{id}"
 *     },
 *     "delete"={
 *          "path"="/tag/{id}"
 *     }
 *     }
 * )
 * @ApiFilter(BooleanFilter::class, properties={"isdeleted"})
 * @UniqueEntity(
 *     fields={"libelle"},
 *     errorPath="libelle",
 *     message="libelle existe deja."
 * )
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"grpetag:create", "grpetag:update"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Champ libelle vide")
     * @Assert\NotNull(message="Champ libelle vide")
     * @Groups({"grpetag:create", "grpetag:read", "grpetag:update"})
     *
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ descriptif vide")
     * @Assert\NotNull(message="Champ descriptif vide")
     * @Groups({"grpetag:create", "grpetag:read", "grpetag:update"})
     */
    private $descriptif;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"grpetag:create", "grpetag:read", "grpetag:update"})
     */
    private $isdeleted = false;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeTag::class, mappedBy="tag")
     */
    private $groupeTags;

    public function __construct()
    {
        $this->groupeTags = new ArrayCollection();
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
     * @return Collection|GroupeTag[]
     */
    public function getGroupeTags(): Collection
    {
        return $this->groupeTags;
    }

    public function addGroupeTag(GroupeTag $groupeTag): self
    {
        if (!$this->groupeTags->contains($groupeTag)) {
            $this->groupeTags[] = $groupeTag;
            $groupeTag->addTag($this);
        }

        return $this;
    }

    public function removeGroupeTag(GroupeTag $groupeTag): self
    {
        if ($this->groupeTags->removeElement($groupeTag)) {
            $groupeTag->removeTag($this);
        }

        return $this;
    }
}
