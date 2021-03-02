<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Doctrine\ORM\EntityManagerInterface;
use  App\Entity\GroupeCompetence;

class GrpeCompDataPersister implements DataPersisterInterface
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function supports($data): bool
    {
        // TODO: Implement supports() method.
        return $data instanceof GroupeCompetence;
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
        /*
         $grpeCompetence = $data->getCompetence()->getValues();
        foreach ($grpeCompetence as $grp){
        $grp->setIsdeleted(true);
        }
         */
        $this->entityManager->persist($data);
        $this->entityManager->flush();

    }
}