<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Service\VacancyService;
use App\Service\ApplicationService;
use App\Service\PlatformService;

class VacancyController extends AbstractController
{
    /**
     * @Route("/vacancy/show/{id}", name="show/vacancy")
     */
    public function showVacancy(Request $request, VacancyService $vs, ApplicationService $as, $id)
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
 
                return $this->render('vacancy/showvacancy.html.twig', [
                    'controller_name' => 'ShowVacancyController',
                    'user' => $user,
                    'vacancy' => $vacancy,
                    'company' => $company,
                    'vacancies' => $vacancies,
                    'application' => $application,]);
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
                        'vacancies' => $vacancies,]);
                }
        	}
        }

        else
        {   
            $this->addFlash('notice', 'Registratie en login verplicht om vacatures in te zien');
            return $this->redirect("/login/");
        }
    }

    /**
     * @Route("/vacancy/edit/{id}", name="edit/vacancy")
     */
    public function editUserProfile(VacancyService $vs, PlatformService $ps, $id)
    {
        $user = $this->getUser();
        $vacancy = $vs->getVacancyByID($id);
        $platforms = $ps->getAllPlatforms();

        if($user == $vacancy->getUser() and in_array('ROLE_EMPLOYER', $user->getRoles()))
        {
                return $this->render('vacancy/editvacancy.html.twig', [
                'controller_name' => 'ShowVacancyController',
                'user' => $user,
                'vacancy' => $vacancy,
                'platforms' => $platforms,]);
        }

        else
        {
            return new response('You cannot edit this vacancy');
        }
    }
           
     /**
     * @Route("/vacancy/update/{id}", name="update/vacancy")
     */
    public function UpdateVacancy(Request $request, VacancyService $vs, $id)
    {
        $user = $this->getUser();
        $vacancy = $vs->getVacancyByID($id);
        
        $params["id"] = $id;
        $params["user"] = $user;
        $params["platform"] = $request->request->get("platform");
        $params["function"] = $request->request->get("function");
        $params["level"] = $request->request->get("level");
        $params["location"] = $request->request->get("location");
        $params["job_description"] = $request->request->get("job_description");

        if($user == $vacancy->getUser() or in_array('ROLE_ADMIN', $user->getRoles()))
        {
            if($id == $params['id'])
            {
                $editvacancy = $vs->saveVacancy($params);
                return $this->redirect("/login/");
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
     * @Route("/vacancy/remove/{id}", name="remove/vacancy")
     */
    public function removeVacancy(VacancyService $vs, $id)
    {
        $user = $this->getUser();
        $vacancy = $vs->getVacancyByID($id);

        if($user == $vacancy->getUser() or in_array('ROLE_ADMIN', $user->getRoles()))
        {
            $result = $vs->removeVacancy($id);
            return $this->redirect("/myvacancies/");
            
        }

        else
        {
            return new response('You cannot delete this vacancy');
        }
    }

    /**
     * @Route("/vacancy/add/", name="add/vacancy")
     */
    public function addVacancy(VacancyService $vs, PlatformService $ps)
    {
        $user = $this->getUser();
        $platforms = $ps->getAllPlatforms();

        if($user)
        {
            if(in_array('ROLE_EMPLOYER', $user->getRoles()))
            {
                return $this->render('vacancy/addvacancy.html.twig', [
                'controller_name' => 'AddVacancyController',
                'user' => $user,
                'vacancy' => $vacancy,
                'platforms' => $platforms]);
            }

            else
            {
                return new response('You are not able to add vacancies');
            }
        }
    }

     /**
     * @Route("/vacancy/save/", name="save/vacancy")
     */
    public function saveVacancy(Request $request, VacancyService $vs, PlatformService $ps)
    {
        $user = $this->getUser();
        $platforms = $ps->getAllPlatforms();

        $params["id"] = null;
        $params["user"] = $user;
        $params["platform"] = $request->request->get("platform");
        $params["function"] = $request->request->get("function");
        $params["level"] = $request->request->get("level");
        $params["location"] = $request->request->get("location");
        $params["job_description"] = $request->request->get("job_description");

        if($user)
        {
            if(in_array('ROLE_EMPLOYER', $user->getRoles()))
            {
                $savevacancy = $vs->saveVacancy($params);
                return $this->redirect("/login/");
            }

            else
            {
                return new response('You are not able to add vacancies');
            }
        }
    }

    /**
    * @Route("/myvacancies/", name="myvacancies")
    */
    public function showVacanciesByUser(VacancyService $vs)
    {
        $user = $this->getUser();
        $vacancies = $vs->getVacanciesByUser($user);
       
        if($user)
        {
            return $this->render('vacancy/employervacancies.html.twig', [
                'controller_name' => 'AddVacancyController',
                'user' => $user,
                'vacancies' => $vacancies,]);
        }

        else
        {
            return false;
        }   
    }
}