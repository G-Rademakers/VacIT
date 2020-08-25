<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function saveUser($params)
    {
        if(isset($params["id"]))
        {
            $user = $this->find($params["id"]);
        } 

        else
        {
            $user = new User();
        } 

        $user->setFirstName($params["first_name"]);
        $user->setLastName($params["last_name"]);
        $user->setCompanyName($params["company_name"]);
        $user->setEmail($params["email"]);
        $user->setAddress($params["address"]);
        $user->setZipcode($params["zipcode"]);
        $user->setCity($params["city"]);
        $user->setPhoneNumber($params["phone_number"]);
        $user->setDateOfBirth($params["date_of_birth"]);
        $user->setDescription($params["description"]);
        $user->setProfilePictureURL($params["profile_picture_url"]);
        $user->setCV($params["cv_url"]);
        $user->setType($params["type"]);

        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();

        return($user);
    }

    public function removeUser($id)
    { 
        $user = $this->find($id);
        if($user) 
        {
            $em = $this->getEntityManager();
            $em->remove($user);
            $em->flush();

            return(true);
        }
        return(false);
    }

    public function getAllUsers()
    {
        $users = $this->findAll();
        return($users);
    }

    public function getUserByID($id)
    {
        $user = $this->find($id);
        return($user);
    }

    public function getUsersByType($type)
    {
        $users = $this->findBy(array("type"=>$type));
        return($users);
    }

    public function getUserByEmail($email)
    {
        $user = $this->findOneBy(["email" => $email]);
        if($email == true)
        {
            return($user);
        }
        return(false);
    }
}