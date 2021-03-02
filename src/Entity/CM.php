<?php

namespace App\Entity;

use App\Repository\CMRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CMRepository::class)
 * @ApiResource(
 *     itemOperations={
 *       "get"={
 *         "path"="apprenants/{id}",
 *         "defaults"={"id"=null},
 *     }
 *     }
 * )
 */
class CM extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:write"})
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
