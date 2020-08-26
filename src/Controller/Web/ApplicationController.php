<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use App\Service\ApplicationService;
use App\Service\UserService;
use App\Service\VacancyService;

class ApplicationController extends AbstractController
{
    /**
     * @Route("/applications", name="application")
     */
    public function index(ApplicationService $as)
    {
        $applications = $as->getAllApplications();
    
        return $this->render('application/index.html.twig', [
            'controller_name' => 'ApplicationController',
        ]);
    }

     /**
     * @Route("/myapplications", name="application")
     */
    public function showApplications(ApplicationService $as, 
                                     VacancyService $vs, 
                                     UserService $us)
    {
        $user = $this->getUser();

        if($user)
        {
            if(in_array('ROLE_CANDIDATE', $user->getRoles()))
            { 
                $applications = $as->getApplicationsByUser($user);

                return $this->render('application/myapplications.html.twig', [
                    'controller_name' => 'MyApplicationsController',
                    'applications' => $applications,
                    'user' => $user]);
            }

            else
            {
                $vacancies = $vs->getVacanciesByUser($user);
                $applicants = $as->getApplicationsByVacancy($vacancies);      
                
                return $this->render('application/myapplicants.html.twig', [
                    'controller_name' => 'MyApplicantsController',
                    'vacancies' => $vacancies,
                    'user' => $user,
                    'applicants' => $applicants]);
            }       
        }
        return new response('false');
    }

     /**
     * @Route("/application/interest/{id}", name="application_interest")
     */
    public function switchInterest(ApplicationService $as, 
                                   VacancyService $vs, $id)
    {
        $user = $this->getUser();
        $vacancy = $vs->getVacancyByID($id);
        $applicants = $as->getApplicationsByVacancy($vacancy);

        if($user == $vacancy->getUser() or in_array('ROLE_ADMIN', $user->getRoles()))
        {
            $application = $as->switchInterest($id);

            return $this->render('application/myapplicants.html.twig', [
                'controller_name' => 'MyApplicantsController',
                'user' => $user,
                'vacancy' => $vacancy,
                'applicants' => $applicants]);
        }
        return new response('false');
    }

     /**
     * @Route("/application/add/{id}", name="application_add")
     */
    public function addApplication(ApplicationService $as, 
                                   VacancyService $vs, $id)
    {
        $keydata = array("user" => $this->getUser(),
                         "vacancy" => $vs->getVacancyByID($id)); 

        // dump($keydata);
        // die();

       if($this->getUser())
       {
           if(in_array('ROLE_CANDIDATE', $this->getUser()->getRoles()))
           {
           $application = $as->saveApplication($keydata);
           dump($application);
           die();
           }
       }
    }
}