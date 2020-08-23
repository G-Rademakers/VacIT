<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use App\Service\VacancyService;
use App\Service\ApplicationService;

class VacancyController extends AbstractController
{
    /**
     * @Route("/vacancy/{id}", name="vacancy")
     */
    public function index(VacancyService $vs, $id)
    {
        $vacancy = $vs->getVacancyByID($id);
        dump($vacancy);
        die();
       
        return $this->render('vacancy/index.html.twig', [
            'controller_name' => 'VacancyController', 'vacancy'=>$vacancy
        ]);
    }

    /**
     * @Route("/vacancy/show/{id}", name="vacancy")
     */
    public function showVacancy(VacancyService $vs, ApplicationService $as, $id)
    {
        $user = $this->getUser();
        $vacancy = $vs->getVacancyByID($id);
    
        // dump($company);
        // die();

        if($user)
        {
            if(in_array('ROLE_CANDIDATE', $user->getRoles()))
            {
                $company = $vacancy->getUser();
                $vacancies = $vs->getVacanciesByUser($company);
                
                return $this->render('vacancy/showvacancy.html.twig', [
                    'controller_name' => 'ShowVacancyController',
                    'user' => $user,
                    'vacancy' => $vacancy,
                    'company' => $company,
                    'vacancies' => $vacancies,
                ]);
            }

            else
            {
                if($user == $vacancy->getUser())
                {
                    $applicants = $as->getApplicationsByVacancy($vacancy);
                    return $this->render('vacancy/showvacancy.html.twig', [
                        'controller_name' => 'ShowVacancyController',
                        'user' => $user,
                        'vacancy' => $vacancy,
                        'applicants' => $applicants,
                    ]);
                }

                else
                {
                    return new response('You have no access to this vacancy');
                }
        	 }
        }

        else
        {
            return new response('Vacancy is not known');
        }
    }

    //  /**
    //  * @Route("/vacancy/edit/{id}", name="editvacancy")
    //  */
    // public function editVacancy(VacancyService $vs, $id)
    // {
    //     $user = $this->getUser();
    //     $vacancy = $vs->getVacancyByID($id);

    //     if($user == $vacancy->getUser())
    //     {
    //         // $editvacancy = $vs->saveVacancy($id);

    //         return $this->render('vacancy/editvacancy.html.twig', [
    //             'controller_name' => 'EditVacancyController',
    //             'user' => $user,
    //             'vacancy' => $vacancy,
    //             // 'editvacancy' => $editvacancy,
    //         ]);
    //     }

    //     else
    //     {
    //         return new response('Vacancy is not known');
    //     }
    // }

    // /**
    //  * @Route("/vacancy/remove/{id}", name="removevacancy")
    //  */
    // public function removeVacancy(VacancyService $vs, $id)
    // {
    //     $user = $this->getUser();
    //     $vacancy = $vs->getVacancyByID($id);

    //     if($user == $vacancy->getUser())
    //     {
    //         $result = $vs->removeVacancy($id);
    //         dump($result);
    //         die();
    //     }

    //     else
    //     {
    //         return new response('You cannot delete this vacancy');
    //     }
    // }

    // /**
    //  * @Route("/vacancy/add", name="addvacancy")
    //  */
    // public function addVacancy(VacancyService $vs)
    // {
    //     $user = $this->getUser();  
    //     $params = array(
    //         "user_id" => 9,
    //         "platform_id" => 8,
    //         "function" => "Data Tester",
    //         "level" => "Junior",
    //         "location" => "Zaandam",
    //         "job_description" => "N.V.T.",
    //         "logo" => null,
    //     );

    //     if($user)
    //     {
    //         if(in_array('ROLE_EMPLOYER', $user->getRoles()))
    //         {
    //            $result = $vs->saveVacancy($params);
    //            dump($result);
    //            die();
    //         }

    //         else
    //         {
    //             return new response('You are not able to add vacancies');
    //         }
    //     }
    // }
}
