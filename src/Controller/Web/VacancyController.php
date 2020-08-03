<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class VacancyController extends AbstractController
{
    /**
     * @Route("/vacancy", name="vacancy")
     */
    public function index()
    {
        return $this->render('vacancy/index.html.twig', [
            'controller_name' => 'VacancyController',
        ]);
    }
}
