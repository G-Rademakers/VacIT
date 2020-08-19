<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\VacancyService;

class VacancyController extends AbstractController
{
    /**
     * @Route("/vacancy/showvacancy/{id}", name="vacancy")
     */
    public function index(VacancyService $vs, $id)
    {
        $vacancy = $vs->getVacancyByID($id);
        dump($vacancy);
        die();
       
        return $this->render('vacancy/index.html.twig', [
            'controller_name' => 'VacancyController',
        ]);
    }

}
