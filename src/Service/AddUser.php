<?php
namespace App\Service;

use App\Repository\ProfilRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class AddUser
{

    public function serviceCreateUser($user, $userAjouter, $encoder,$request, $manager, $isdeleted)
    {
        if(isset($userAjouter['prenom'])){
            $user->setPrenom($userAjouter['prenom']);
        }
        if(isset($userAjouter['nom'])){
            $user->setNom($userAjouter['nom']);
        }
        if(isset($userAjouter['email'])){
            $user->setEmail($userAjouter['email']);
        }
        if(isset($userAjouter['password'])){
            $password = $userAjouter['password'];
            $user->setPassword($encoder->encodePassword($user, $password));
        }
        if(isset($isdeleted)){
            $user->setIsdeleted($isdeleted);
        }
        if($request->files->get("avatar") !== null){
            $avatar = $request->files->get("avatar");
            $avatar = fopen($avatar->getRealPath(),"rb");
            $user->setAvatar($avatar);
        }
        $manager->persist($user);
        $manager->flush();
        if($request->files->get("avatar") !== null){
            fclose($avatar);
        }
    }

    public function serviceReadUser($repository){
        $users = $repository->findAll();
        return $users;
    }
}