<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\GroupeTag;
use Doctrine\ORM\EntityManagerInterface;


class GroupeTagDataPersister implements DataPersisterInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function supports($data): bool
    {
        // TODO: Implement supports() method.
        return $data instanceof GroupeTag;
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
        $tags = $data->getTag();
        foreach ($tags as $tag){
            $data->removeTag($tag);
        }
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}
