<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Formateur;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"user" = "User", "apprenant" = "Apprenant", "formateur" = "Formateur", "cm"="CM"})
 *
 * @ApiResource(
 *    attributes={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Vous n'avez pas l'acces"
 *      },
 *    collectionOperations={
 *     "get"={
 *          "method"="GET",
 *          "path"="admin/users",
 *          "normalization_context"={"groups":"user:write"},
 *
 *     },
 *     "postUser"={
 *          "path"="admin/users",
 *          "route_name"="saveUser",
 *          "method"="POST",
 *          "deserialize"=false,
 *     }
 *     },
 *     itemOperations={
 *      "get"={
 *         "path"="formateur/{id}",
 *         "defaults"={"id"=null},
 *     },
 *       "putUser"={
 *          "path"="admin/user/{id}",
 *          "method"="PUT",
 *          "route_name"="updateUser",
 *          "deserialize"=false,
 *     },
 *     "delete"={
 *          "path"="admin/user/{id}"
 *     }
 *    }
 * )
 * @ApiFilter(NumericFilter::class, properties={"profil.id"})
 * @ApiFilter(BooleanFilter::class, properties={"isdeleted"})
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"apprenant:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user:write", "apprenant:read", "apprenant:read", "profil:read", "formateurs:read"})
     * @Assert\NotBlank(message="Champ email vide")
     * @Assert\NotNull
     * @Assert\Unique
     * @Groups({"user:write"})
     */
    private $email;


    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Champ password vide")
     * @Assert\NotNull
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:write", "formateurs:read"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:write", "formateurs:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="blob", nullable=true)
     *
     */
    private $avatar;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isdeleted;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     * @Groups({"user:write", "formateurs:read"})
     *
     */
    private $profil;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->profil->getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getIsdeleted(): ?bool
    {
        return $this->isdeleted;
    }

    public function setIsdeleted(bool $isdeleted): self
    {
        $this->isdeleted = $isdeleted;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }
}
