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

    public function updateUser($params)
    {
    
    }

    public function createUser($params)
    {
        $u = $this->um->findUserByEmail($params["email"]);
        if(!$u)
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
}