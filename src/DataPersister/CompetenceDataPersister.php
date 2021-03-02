<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Doctrine\ORM\EntityManagerInterface;
use  App\Entity\Competence;

class CompetenceDataPersister implements DataPersisterInterface
{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function supports($data): bool
    {
        // TODO: Implement supports() method.
        return $data instanceof Competence;
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
        $niveaux = $data->getNiveaux()->getValues();
        foreach ($niveaux as $niveau){
            $niveau->setIsdeleted(true);
        }
        $this->entityManager->persist($data);
        $this->entityManager->flush();

    }
}