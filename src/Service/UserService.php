<?php

namespace App\Service;

use App\Entity\User;

use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    private $em;
    private $um;
    private $encoder;

    public function __construct(EntityManagerInterface $em,
                                UserManagerInterface $um,
                                UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->um = $um;
        $this->encoder = $encoder;
    }

    public function saveUser($params)
    {
        $user = $this->um->findUserBy(array('id' => $params["id"]));
        
        if($user)
        {   
            if(isset($params["first_name"]))
            {
                $user->setFirstName($params["first_name"]);
            }

            if(isset($params["last_name"]))
            {
                $user->setLastName($params["last_name"]);
            }
            
            if(isset($params["company_name"]))
            {
                $user->setCompanyName($params["company_name"]);
            }
            
            if(isset($params["address"]))
            {
                $user->setAddress($params["address"]);
            }
            
            if(isset($params["zipcode"]))
            {
                $user->setZipcode($params["zipcode"]);
            }

            if(isset($params["city"]))
            {
                $user->setCity($params["city"]);
            }
            
            if(isset($params["phone_number"]))
            {
                $user->setPhoneNumber($params["phone_number"]);
            }
           
            if(isset($params["date_of_birth"]))
            {
                $user->setDateOfBirth($params["date_of_birth"]);
            }

            if(isset($params["description"]))
            {
                $user->setDescription($params["description"]);
            }

            if(isset($params["profile_picture_url"]))
            {
                $user->setDescription($params["profile_picture_url"]);
            }
          
            if(isset($params["cv_url"]))
            {
                $user->setDescription($params["cv_url"]);
            }
          
            $this->um->UpdateUser($user);

            return($user);
        }
        return(false);
    }

    public function createUser($params)
    {
        foreach($params as $param)
        {
            $user = $this->um->findUserBy(array('username' => $param["username"]));
            if($user == false)
            {
                $user = $this->um->createUser();
                $user->setUsername($param["username"]);
                $user->setEmail($param["email"]);
                $user->setEnabled(true);
                $user->addRole($param["roles"]);
                $password = $this->encoder->encodePassword($user, $param["password"]);
                $user->setPassword($password);
                $user->setFirstName($param["first_name"]);
                $user->setLastName($param["last_name"]);
                $user->setCompanyName($param["company_name"]);
                $user->setAddress($param["address"]);
                $user->setZipcode($param["zipcode"]);
                $user->setCity($param["city"]);
                $user->setPhoneNumber($param["phone_number"]);
                $user->setDescription($param["description"]);
                $user->setProfilePictureURL($param["profile_picture_url"]);
    
                $this->um->updateUser($user);
            }
        }
        return(true);
    }

    public function deleteUser($id)
    {
       $userfind = $this->um->findUserBy(array('id'=>$id));
       if($userfind)
       {   
            $user = $this->um->deleteUser($userfind);
            return($user);
       }
       return(false);
    }

    public function findUserByID($id)
    {
        $user = $this->um->findUserBy(array('id'=>$id));
        if($user)
        {
            return($user);
        }
        return(false);
    }

    public function findAllUsers()
    {
       $users= $this->um->findUsers();
       return($users);
    }
}