<?php

namespace App\Service;

use App\Entity\Platform;

use Doctrine\ORM\EntityManagerInterface;

class PlatformService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAllPlatforms()
    {
        $platforms = $this->em->getRepository(Platform::class);
        $result = $platforms->getAllPlatforms();
        return($result);
    }
    
    public function getPlatformByID($id)
    {
        $platform = $this->em->getRepository(Platform::class);
        $result = $platform->getPlatformbyID($id);
        return($result);
    }

    public function savePlatform($params)
    {
        $platform = $this->em->getRepository(Platform::class);
        $result = $platform->savePlatform($params);
        return($result);
    }

    public function removePlatform($id)
    {
        $platform = $this->em->getRepository(Platform::class);
        $result = $platform->removePlatform($id);
        return($result);
    }
}