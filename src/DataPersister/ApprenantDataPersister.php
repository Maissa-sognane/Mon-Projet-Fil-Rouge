<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Apprenant;
use Doctrine\ORM\EntityManagerInterface;

class ApprenantDataPersister implements DataPersisterInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function supports($data): bool
    {
        return $data instanceof Apprenant;
        // TODO: Implement supports() method.
    }

    public function persist($data)
    {
        $this->entityManager->persist($data);
        $this->entityManager->flush();
        // TODO: Implement persist() method.
    }

    public function remove($data)
    {
        $data->setIsdeleted(true);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
        // TODO: Implement remove() method.
    }
}