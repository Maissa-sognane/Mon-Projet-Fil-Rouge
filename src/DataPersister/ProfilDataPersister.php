<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Profil;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfilDataPersister implements DataPersisterInterface
{
    private $entityManager;
    private $userPasswordEncoder;
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function supports($data): bool
    {
        // TODO: Implement supports() method.
        return $data instanceof Profil;
    }

    public function persist($data)
    {
        // TODO: Implement persist() method.
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        $data->setIsdeleted(true);
        $users = $data->getUsers()->getValues();
        foreach ($users as $user){
            $user->setIsdeleted(true);
        }
        $this->entityManager->persist($data);
        $this->entityManager->flush();
        // TODO: Implement remove() method.
    }
}
