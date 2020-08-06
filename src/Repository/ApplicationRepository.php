<?php

namespace App\Repository;

use App\Repository\UserRepository;
use App\Repository\VacancyRepository;

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

    public function SaveApplication($params)
    {
        if(isset($params["id"]))
        {
            $application = $this->find($params["id"]);
        }
        
        else
        {
            $application = new Application;

            $em = $this->getEntityManager();

            $userRepository = $em->getRepository(User::class);
            $vacancyRepository = $em->getRepository(Vacancy::class);

            $user = $userRepository->find($params["user_id"]);
            $vacancy = $vacancyRepository->find($params["vacancy_id"]);

            $application = setUser($user);
            $application = setVacancy($vacancy);
            $application = setApplicationDate($params["application_date"]);
            $application = setInvited($params["invited"]);

            $em->persist($application);
            $em->flush();

            return($application);
        }
    }

    public function GetAllApplications()
    { 
        $applications = $this->findAll();
        return($applications);
    }

    public function GetApplicationByID($id)
    {
        $application = $this->find($id);
        return($application);
    }

    public function GetApplicationsByUser($user)
    {
        $applications = $this->findBy(array("user"=>$users));
        return($applications);
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
}
