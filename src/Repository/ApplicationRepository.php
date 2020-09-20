<?php

namespace App\Repository;

use App\Entity\Application;
use App\Entity\User;
use App\Entity\Vacancy;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ApplicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Application::class);
    }

    public function saveApplication($params)
    {
        $retrieveddata = $this->findBy(array("user" => $params["user"], "vacancy" => $params["vacancy"]));
        
        if($retrieveddata)
        {
            return(false);
        }

        else
        {
            $application = new Application();

            $em = $this->getEntityManager();

            $userRepository = $em->getRepository(User::class);
            $vacancyRepository = $em->getRepository(Vacancy::class);

            $user = $userRepository->find($params["user"]);
            $vacancy = $vacancyRepository->find($params["vacancy"]);
            $date = date('Y-m-d', time());

            $application->setUser($user);
            $application->setVacancy($vacancy);
            $application->setInvited(false);
            $application->setApplicationDate($date);

            $em->persist($application);
            $em->flush();

            return($application);
        }
    }

    public function removeApplication($id)
    {
        $application = $this->find($id);
        if($application) 
        {
            $em = $this->getEntityManager();
            $em->remove($application);
            $em->flush();

            return(true);
        }
        return(false);
    }

    public function getAllApplications()
    {
        $applications = $this->FindAll();
        return($applications);
    }

    public function getApplicationByID($id)
    {
        $application = $this->find($id);
        return($application);
    }

    public function getApplicationsByUser($user)
    {
        $applications = $this->findBy(array("user"=>$user));
        return($applications);
    }

    public function getApplicationsByVacancy($vacancy)
    {
        $applications = $this->findBy(array("vacancy"=>$vacancy));
        return($applications);
    }

    public function switchInvitation($id)
    {
        $application = $this->find($id);
        
        if($application->getInvited() == false)
        {
            $application->setInvited(true);
        }

        else
        {
            if($application->getInvited() == true)
            {
                $application->setInvited(false);
            }
        }

        $em = $this->getEntityManager();
        $em->persist($application);
        $em->flush();

        return($application);
    }
}