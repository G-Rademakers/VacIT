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
        
        if(isset($user))
        {   
            $user->setUsername($params["username"]);
            $user->setEmail($params["email"]);
            $user->setPassword($params["password"]);
            $user->setFirstName($params["first_name"]);
            $user->setLastName($params["last_name"]);
            $user->setCompanyName($params["company_name"]);
            $user->setAddress($params["address"]);
            $user->setZipcode($params["zipcode"]);
            $user->setCity($params["city"]);
            $user->setPhoneNumber($params["phone_number"]);
            $user->setDateOfBirth($params["date_of_birth"]);
            $user->setDescription($params["description"]);
            $user->setProfilePictureURL($params["profile_picture_url"]);
            $user->setCV($params["cv_url"]);
            $user->setType($params["type"]);

            $this->um->UpdateUser($user);

            return($user);
        }

        else
        {
            return("User does not exist");
        }

    }

    public function createUser($params)
    {
        $user = $this->um->findUserByEmail($params["email"]);
        if($user == false)
        {
            $user = $this->um->createUser();
            $user->setUsername($params["username"]);
            $user->setEmail($params["email"]);
            $user->setEnabled(true);
            $user->addRole($params["roles"]);
            $password = $this->encoder->encodePassword($user, $params["password"]);
            $user->setPassword($password);

            $this->um->updateUser($user);

            return($user);
        }
        else
        {
            return("User already exists");
        }    

    }

   public function deleteUser($id)
   {
       $userfind = $this->um->findUserBy(array('id'=>$id));
       if($userfind)
       {   
            $user = $this->um->deleteUser($userfind);
            return($user);
       }

       else
       {
           return("User does not exist");
       }
   }

   public function findUser($id)
   {
        $user = $this->um->findUserBy(array('id'=>$id));
        if($user)
        {
            return($user);
        }

        else
        {
            return("No User Found");
        }
   }

   public function findAllUsers()
   {
       $users= $this->um->findUsers();
       return($users);
   }


//    public function findUsersByRole($roles)
//    {
//        $userfind = $this->um->FindUserBy(array('roles' => $roles));
//        if($userfind)
//        {
//            return($userfind);
//        }
       
//        else
//        {
//            return(null);
//        }
//    }
}