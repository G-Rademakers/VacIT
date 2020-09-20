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
     * @Route("/application/invitation/{id}", name="application_invitation")
     */
    public function switchInvitation(ApplicationService $as, 
                                     VacancyService $vs, $id)
    {
        $user = $this->getUser();
        $applicants = $as->getApplicationsByVacancy($vacancy);

        if(in_array('ROLE_EMPLOYER', $user->getRoles()) or in_array('ROLE_ADMIN', $user->getRoles()))
        {
            $application = $as->switchInvitation($id);

            return $this->redirect("/myapplications");

        }
        return new response('No Access');
    }

     /**
     * @Route("/application/add/{id}", name="application_add")
     */
    public function addApplication(ApplicationService $as, 
                                   VacancyService $vs, $id)
    {
        $keydata = array("user" => $this->getUser(),
                         "vacancy" => $vs->getVacancyByID($id)); 

        if($this->getUser())
        {
            $application = $as->saveApplication($keydata);
            return $this->redirect("/myapplications");
        }
        return $this->redirect("/login");
    }

    //  /**
    //  * @Route("/application/remove/{id}", name="application_remove")
    //  */
    // public function removeApplication(ApplicationService $as, 
    //                                   VacancyService $vs, $id)
    // {
    //     $keydata = array("user" => $this->getUser(),
    //                      "vacancy" => $vs->getVacancyByID($id));       
        
    //     if($this->getUser())
    //     {
    //         $application = $as->removeApplication($keydata);
    //         return $this->redirect("/myapplications");
    //     }
    //         return $this->redirect("/login");
    // }
}
