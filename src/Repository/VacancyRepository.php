<?php

namespace App\Repository;

use App\Entity\Vacancy;
use App\Entity\User;
use App\Entity\Platform;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VacancyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vacancy::class);
    }

    public function saveVacancy($params)
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
        $vacancy->setVacancyDate($params["vacancy_date"]);

        $em->persist($vacancy);
        $em->flush();

        return($vacancy);
    }

    public function removeVacancy($id)
    { 
        $vacancy = $this->find($id);
        if($vacancy) 
        {
            $em = $this->getEntityManager();
            $em->remove($vacancy);
            $em->flush();

            return(true);
        }
        return(false);
    }
    
    public function getAllVacancies()
    {
        $vacancies = $this->findAll();
        return($vacancies);
    }

    public function getVacancyByID($id)
    {
        $vacancy = $this->find($id);
        return($vacancy);
    }

    public function getVacanciesByUser($user)
    {
        $vacancies = $this->findBy(array("user"=>$user));
        return($vacancies); 
    }

   public function getRecentVacancies()
   {
       $vacancies = $this->findBy(array(), array('vacancy_date' => 'DESC'), 5, 0);
       return($vacancies);
   }

   public function getVacanciesByDate()
   {
       $vacancies = $this->findBy(array(), array('vacancy_date' => 'ASC'), 100, 0);
       return($vacancies);
   }
}
