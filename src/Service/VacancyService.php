<?php

namespace App\Service;

use App\Entity\Vacancy;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;

class VacancyService
{
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAllVacancies()
    {
        $vacancies = $this->em->getRepository(Vacancy::class);
        $result = $vacancies->getAllVacancies();
        return($result);
    }

    public function getVacancyByID($id)
    {
        $vacancy = $this->em->getRepository(Vacancy::class);
        $result = $vacancy->getVacancyByID($id);
        return($result);
    }

    public function getVacanciesByUser($user)
    {
        $vacancies = $this->em->getRepository(Vacancy::class);
        $result = $vacancies->getVacanciesByUser($user);
        return($result);
    }

    public function saveVacancy($params)
    {
        $vacancy = $this->em->getRepository(Vacancy::class);
        $result = $vacancy->saveVacancy($params);
        return($result);
    }

    public function removeVacancy($id)
    {
        $vacancy = $this->em->getRepository(Vacancy::class);
        $result = $vacancy->removeVacancy($id);
        return($result);
    }

    public function getRecentVacancies()
    {
        $vacancies = $this->em->getRepository(Vacancy::class);
        $result = $vacancies->getRecentVacancies();
        return($result);
    }
}