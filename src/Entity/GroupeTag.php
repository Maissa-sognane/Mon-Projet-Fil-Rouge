<?php

namespace App\Entity;

use App\Repository\GroupeTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiSubresource;


/**
 * @ORM\Entity(repositoryClass=GroupeTagRepository::class)
 * @ApiResource (
 * attributes={
 *          "security"="is_granted('ROLE_FORMATEUR')",
 *          "security_message"="Vous n'avez pas l'acces aux ressources"
 *      },
 *      routePrefix="/admin",
 *      collectionOperations={
 *       "get"={
 *          "path"="/grptags",
 *          "normalization_context"={"groups":"grpetag:read"},
 *     },
 *       "postgrpetag"={
 *          "path"="/grptags",
 *          "route_name"="creategrptag",
 *          "method"="POST",
 *          "denormalization_context"={"groups"={"grpetag:create"}},
 *
 *
 *     }
 *     },
 *     itemOperations={
 *       "putgrpetag"={
 *          "path"="/grptag/{id}",
 *          "method"="PUT",
 *          "route_name"="updategrptag",
 *          "denormalization_context"={"groups"={"grpetag:update"}},
 *     },
 *     "get"={
 *          "path"="/grptag/{id}",
 *          "normalization_context"={"groups":"grpetag:read"},
 *     },
 *   "delete"={
 *          "path"="/grptag/{id}"
 *     },
 *    "get"={
 *          "path"="/grptag/{id}/tags",
 *          "normalization_context"={"groups":"tagpargroupe:read"},
 *     },
 *     }
 * )
 * @UniqueEntity(
 *     fields={"libelle"},
 *     errorPath="libelle",
 *     message="libelle existe deja."
 * )
 * @ApiFilter(BooleanFilter::class, properties={"isdeleted"})
 */
class GroupeTag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"grpetag:read", "grpetag:update", "tagpargroupe:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"grpetag:read"})
     * @Assert\NotBlank(message="Champ libelle vide")
     * @Assert\NotNull(message="Champ libelle vide")
     * @Groups({"grpetag:read", "grpetag:create", "grpetag:update"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"grpetag:read", "grpetag:create", "grpetag:update"})
     */
    private $isdeleted = false;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="groupeTags")
     * @Groups({"grpetag:create", "grpetag:read", "grpetag:update", "tagpargroupe:read"})
     *  @ApiSubresource
     */
    private $tag;

    public function __construct()
    {
        $this->tag = new ArrayCollection();
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
     * @return Collection|Tag[]
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tag->removeElement($tag);

        return $this;
    }
}
