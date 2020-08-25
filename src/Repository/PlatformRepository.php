<?php

namespace App\Repository;

use App\Entity\Platform;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PlatformRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Platform::class);
    }

    public function savePlatform($params)
    {
        if(isset($params["id"]))
        {
            $platform = $this->find($params["id"]);
            return("Data already exists");
        } 

        else
        {
            $platform = new Platform();
        } 

        $platform->setName($params["name"]);
        $platform->setIconURL($params["icon_url"]);

        $em = $this->getEntityManager();
        $em->persist($platform);
        $em->flush();

        return($platform);
    }

    public function removePlatform($id)
    { 
        $platform = $this->find($id);
        if($platform) 
        {
            $em = $this->getEntityManager();
            $em->remove($platform);
            $em->flush();

            return(true);
        }
        return(false);
    }

    public function getAllPlatforms()
    {
        $platforms = $this->findAll();
        return($platforms);
    }

    public function getPlatformById($id)
    {
        $platform = $this->find($id);
        return($platform);
    }
}
