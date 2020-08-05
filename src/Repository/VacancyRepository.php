<?php

namespace App\Repository;

use App\Repository\VacancyRepository;
use App\Repository\UserRepository;
use App\Entity\Vacancy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vacancy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vacancy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vacancy[]    findAll()
 * @method Vacancy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VacancyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vacancy::class);
    }

    public function SaveVacancy($params)
    {
        if(isset($params["id"]))
        {
            $vacancy = $this->find($params["id"]);
        } 

        else
        {
            $vacancy = new Vacancy();
        } 

        $em = $this->getEntityManager();

        $userRepository = $em->getRepository(User::class);
        $platformRepository = $em->getRepository(Platform::class);

        $user = $userRepository->find($params["user_id"]);
        $platform = $platformRepository->find($params["platform_id"]);

        $vacancy->setUser($user);
        $vacancy->setPlatform($platform);
        $vacancy->setFunction($params["function"]);
        $vacancy->setLevel($params["level"]);
        $vacancy->setLocation($params["location"]);
        $vacancy->setJobDescription($params["job_description"]);
        $vacancy->setLogo($params["logo"]);

        $em->persist($platform);
        $em->flush();

        return($vacancy);
    }
    
    public function FindAllVacancies()
    {
        $vacansies = $this->findAll();
        return($vacansies);
    }

    public function FindVacancyByID($id)
    {
        $vacancy = $this->find($id);
        return($vacancy);
    }

   

    // /**
    //  * @return Vacancy[] Returns an array of Vacancy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vacancy
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
