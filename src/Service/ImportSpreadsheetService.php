<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\User;

class ImportSpreadsheetService
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->rep = $this->em->getRepository(User::class);
    }

    public function ImportSpreadsheet($params)
    {
        foreach ($params as $param)
        {
            $user = $this->rep->getUserByEmail($param["email"]);
            if(!$user)
            {
                $users = $this->rep->saveUser($params);
            }
        }
    }
}