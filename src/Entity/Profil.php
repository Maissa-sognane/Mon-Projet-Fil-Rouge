<?php

namespace App\Entity;

use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 * @ApiResource(
 *  attributes={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Vous n'avez pas l'acces",
 *          "filters"={"offer.date_filter"}
 *      },
 *     collectionOperations={
 *     "get"={
 *       "path"="admin/profils",
 *       "normalization_context"={"groups":"profil:read"},
 *
 *     },
 *     "post" = {
 *       "path"="admin/profils",
 *     },
 *     },
 *     itemOperations={
 *       "getProfilById"={
 *         "method"="GET",
 *         "path"="admin/profils/{id}/users",
 *         "route_name"="ListerprofilparId",
 *         "normalization_context"={"groups":"profil:read"},
 *     },
 *     "get"={
 *          "path"="admin/profil/{id}",
 *           "normalization_context"={"groups":"profil:read"},
 *     },
 *     "put"={
 *          "path"="admin/profil/{id}"
 *     },
 *      "delete"={
 *          "path"="admin/profil/{id}"
 *     }
 *     }
 * )
 * @ApiFilter(BooleanFilter::class, properties={"isdeleted"})
 */
class Profil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"profil:read"})
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"profil:read"})
     * @Assert\NotBlank(message="Champ profil vide")
     * @Assert\NotNull(message="Champ profil vide")
     *
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isdeleted = false;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profil")
     * @Groups({"profil:read"})
     *
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setProfil($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfil() === $this) {
                $user->setProfil(null);
            }
        }

        return $this;
    }
}
