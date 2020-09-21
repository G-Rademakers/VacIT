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
     * @Route("/vacancy/show/{id}", name="vacancy")
     */
    public function showVacancy(VacancyService $vs, ApplicationService $as, $id)
    {
        $user = $this->getUser();
        $vacancy = $vs->getVacancyByID($id);
        $keydata = array("user" => $this->getUser(),
                         "vacancy" => $vs->getVacancyByID($id));

        if($user)
        {
            if(in_array('ROLE_CANDIDATE', $user->getRoles()) or in_array('ROLE_ADMIN', $user->getRoles()))
            {
                $company = $vacancy->getUser();
                $vacancies = $vs->getVacanciesByUser($company);
                $application = $as->getApplicationByUserAndVacancy($keydata);
                // dump($application);
                // die();
                
                return $this->render('vacancy/showvacancy.html.twig', [
                    'controller_name' => 'ShowVacancyController',
                    'user' => $user,
                    'vacancy' => $vacancy,
                    'company' => $company,
                    'vacancies' => $vacancies,
                    'application' => $application,
                ]);
            }

            else
            {
                if(in_array('ROLE_EMPLOYER', $user->getRoles()) or in_array('ROLE_ADMIN', $user->getRoles()))
                {
                    $applicants = $as->getApplicationsByVacancy($vacancy);
                    return $this->render('vacancy/showvacancy.html.twig', [
                        'controller_name' => 'ShowVacancyController',
                        'user' => $user,
                        'vacancy' => $vacancy,
                        'applicants' => $applicants,
                        'vacancies' => $vacancies,
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

     /**
     * @Route("/vacancy/edit/{id}", name="editvacancy")
     */
    public function editVacancy(VacancyService $vs, $id)
    {
        $user = $this->getUser();
        $vacancy = $vs->getVacancyByID($id);
        $params = array(
            "id" => 21,
            "user_id" => 9,
            "platform_id" => 8,
            "function" => "Werkt dit nog steeds?",
            "level" => "Medior",
            "location" => "Amstelveen",
            "job_description" => "Tester",
            "logo" => null,
        );

        if($user == $vacancy->getUser() or in_array('ROLE_ADMIN', $user->getRoles()))
        {
            if($id == $params['id'])
            {
                $editvacancy = $vs->saveVacancy($params);
                
                return $this->render('vacancy/editvacancy.html.twig', [
                    'controller_name' => 'EditVacancyController',
                    'user' => $user,
                    'vacancy' => $vacancy,
                    'editvacancy' => $editvacancy]);
                
                // dump($editvacancy);
                // die();
            }

            else
            {
                return new response('Cannot change this vacancy');
            }
         
        }

        else
        {
            return new response('Vacancy is not accessible');
        }
    }

    /**
     * @Route("/vacancy/remove/{id}", name="removevacancy")
     */
    public function removeVacancy(VacancyService $vs, $id)
    {
        $user = $this->getUser();
        $vacancy = $vs->getVacancyByID($id);

        if($user == $vacancy->getUser() or in_array('ROLE_ADMIN', $user->getRoles()))
        {
            $result = $vs->removeVacancy($id);

            return $this->render('vacancy/removevacancy.html.twig', [
                'controller_name' => 'RemoveVacancyController',
                'user' => $user,
                'vacancy' => $vacancy,
                'result' => $result]);
        }

        else
        {
            return new response('You cannot delete this vacancy');
        }
    }

    /**
     * @Route("/vacancy/add", name="addvacancy")
     */
    public function addVacancy(VacancyService $vs)
    {
        $user = $this->getUser();

        if($user)
        {
            if(in_array('ROLE_EMPLOYER', $user->getRoles()))
            {
               $result = $vs->saveVacancy($params);

               return $this->render('vacancy/addvacancy.html.twig', [
                'controller_name' => 'AddVacancyController',
                'user' => $user,
                'vacancy' => $vacancy,
                'result' => $result]);
            }

            else
            {
                return new response('You are not able to add vacancies');
            }
        }
    }
}
