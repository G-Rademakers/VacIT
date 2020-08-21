<?php 

namespace App\Service;

use App\Entity\Application;

use Doctrine\ORM\EntityManagerInterface;

class ApplicationService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAllApplications()
    {
        $applications = $this->em->getRepository(Application::class);
        $result = $applications->getAllApplications();
        return($result);
    }

    public function getApplicationByID($id)
    {
        $application = $this->em->getRepository(Application::class);
        $result = $application->getApplicationByID($id);
        return($result);
    }

    public function getApplicationsByUser($user)
    {
        $applications = $this->em->getRepository(Application::class);
        $result = $applications->getApplicationsByUser($user);
        return($result);
    }

    public function saveApplication($params)
    {
        $application = $this->em->getRepository(Application::class);
        $result = $application->saveApplication($params);
        return($result);
    }

    public function removeApplication($id)
    {
        $application = $this->em->getRepository(Application::class);
        $result = $application->removeApplication($id);
        return($result);
    }

    public function getApplicationsByVacancy($vacancy)
    {
        $applications = $this->em->getRepository(Application::class);
        $result = $applications->getApplicationsByVacancy($vacancy);
        return($result);
    }
}

