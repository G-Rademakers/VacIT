<?php

namespace App\Repository;

use App\Entity\Application;
use App\Entity\User;
use App\Entity\Vacancy;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Application|null find($id, $lockMode = null, $lockVersion = null)
 * @method Application|null findOneBy(array $criteria, array $orderBy = null)
 * @method Application[]    findAll()
 * @method Application[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class ApplicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Application::class);
    }

    public function saveApplication($params)
    {
        if(isset($params["id"]))
        {
            $application = $this->find($params["id"]);
        }

        else
        {
            $application = new Application();

            $em = $this->getEntityManager();

            $userRepository = $em->getRepository(User::class);
            $vacancyRepository = $em->getRepository(Vacancy::class);

            $user = $userRepository->find($params["user_id"]);
            $vacancy = $vacancyRepository->find($params["vacancy_id"]);

            $application->setUser($user);
            $application->setVacancy($vacancy);
            $application->setApplicationDate($params["application_date"]);
            $application->setInvited($params["invited"]);

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

    public function switchInterest($id)
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
    // /**
    //  * @return Application[] Returns an array of Application objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Application
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

