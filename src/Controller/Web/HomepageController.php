<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\VacancyService;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(VacancyService $vs)
    {
        $vacancies = $vs->getRecentVacancies();

        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'Homepage Controller', 
            'vacancies'=>$vacancies,
        ]);
    }

     /**
     * @Route("/vacancies", name="Homepage_AllVacancies")
     */
    public function showAllVacancies(VacancyService $vs)
    {
        $vacancies = $vs->getAllVacancies();

        return $this->render('homepage/alternative/index.html.twig', [
            'controller_name' => 'Alternative Homepage Controller', 
            'vacancies'=>$vacancies,
        ]);
    }
}
