<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\VacancyService;
use App\Service\PlatformService;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(VacancyService $vs, PlatformService $ps)
    {
        $vacancies = $vs->getRecentVacancies();
        $platforms = $ps->getAllPlatforms();
        
        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'Homepage Controller', 
            'vacancies'=>$vacancies,
            'platforms'=>$platforms,]);
    }

     /**
     * @Route("/vacancies", name="Homepage_AllVacancies")
     */
    public function showAllVacancies(VacancyService $vs)
    {
        $vacancies = $vs->getVacanciesByDate();

        return $this->render('homepage/alternative/index.html.twig', [
            'controller_name' => 'Alternative Homepage Controller', 
            'vacancies'=>$vacancies,]);
    }
}
