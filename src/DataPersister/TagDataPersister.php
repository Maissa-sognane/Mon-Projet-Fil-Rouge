<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TagDataPersister implements DataPersisterInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function supports($data): bool
    {
        // TODO: Implement supports() method.
        return $data instanceof Tag;
    }

    public function persist($data)
    {
        // TODO: Implement persist() method.
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        // TODO: Implement remove() method.
        $data->setIsdeleted(true);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}