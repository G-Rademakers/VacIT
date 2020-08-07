<?php

namespace App\Controller\Web;

use App\Entity\Platform;
use App\Entity\User;
use App\Entity\Vacancy;
use App\Entity\Application;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Compnent\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index()
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }


#PLATFORM FUNCTIONS TEST

    /**
     * @Route("/test/platform", name="test/platform")
     */
    public function savePlatform()
    {
        $params = array(
            "id" => 2,
            "name" => "Windows",
            "icon_url" => ""
        );

        $rep = $this->getDoctrine()->getRepository(Platform::class);
        $platform = $rep->savePlatform($params);
        dump($platform);
        die();
    }
    
    /**
     * @Route("/test/platform/remove/{id}", name="test/platform/remove")
     */
    public function removePlatform($id)
    {
        $rep = $this->getDoctrine()->getRepository(Platform::class);
        $platform = $rep->removePlatform($id);
        dump($platform);
        die();
    }

    
    /**
     * @Route("/test/platforms/find", name="test/platforms/find")
     */
    public function getAllPlatforms()
    {
        $rep = $this->getDoctrine()->getRepository(Platform::class);
        $platform = $rep->getAllPlatforms();
        dump($platform);
        die();
    }

    /**
    * @Route("/test/platform/find/{id}", name="test/platform/findID")
    */
    public function getPlatform($id)
    {

        $rep = $this->getDoctrine()->getRepository(Platform::class);
        $platform = $rep->getPlatformByID($id);
        dump($platform);
        die();
    }    


 # USER FUNCTIONS TEST

    /**
    * @Route("/test/user", name="test/user")
    */
    public function saveUser()
    {
        $params = array(
            "id" => 5,
            "first_name" => "Bruce",
            "last_name" => "Greene",
            "company_name" => "",
            "address" => "Skastraat 32",
            "zipcode" => "3333",
            "city" => "Assen",
            "phone_number" => "0814534213",
            "date_of_birth" => "2000-12-31",
            "description" => "Regisseur zoekt geheel nieuwe uitdaging binnen de wereld van de IT",
            "profile_picture_url" => "",
            "cv_url" => "",
            "type" => "C"
        );

        $rep = $this->getDoctrine()->getRepository(User::class);
        $user = $rep->saveUser($params);
        dump($user);
        die();
    }

     /**
    * @Route("/test/user/remove/{id}", name="test/user/remove")
    */
    public function removeUser($id)
    {
        $rep = $this->getDoctrine()->getRepository(User::class);
        $user = $rep->removeUser($id);
        dump($user);
        die();
    } 
    
    /**
    * @Route("/test/users/find", name="test/users/find")
    */
    public function getAllUsers()
    {
        $rep = $this->getDoctrine()->getRepository(User::class);
        $users = $rep->getAllUsers();

        dump($users);
        die();
    }    

    /**
    * @Route("/test/user/find/{id}", name="test/user/findID")
    */
    public function getUserByID($id)
    {
        $rep = $this->getDoctrine()->getRepository(User::class);
        $user = $rep->getUserByID($id);

        dump($user);
        die();
    } 

    /**
    * @Route("/test/user/find/{type}", name="test/user/findType")
    */
    public function getUsersByType($type)
    {
        $rep = $this->getDoctrine()->getRepository(User::class);
        $users = $rep->getUsersByType($type);

        dump($users);
        die();
    }


# VACANCY FUNCTIONS TEST

    /**
     * @Route("/test/vacancy", name="test/vacancy")
     */
    public function saveVacancy()
    {
        $params = array(
            "user_id" => 3,
            "platform_id" => 7,
            "function" => "Support",
            "level" => "Junior",
            "location" => "Aalbeek",
            "job_description" => "Temporary job supporting the Aalbeek team",
            "logo" => null
        );

        $rep = $this->getDoctrine()->getRepository(Vacancy::class);
        $vacancy = $rep->saveVacancy($params);
        dump($vacancy);
        die();
    }


    /**
     * @Route("/test/vacancy/remove/{id}", name="test/vacancy/remove")
     */
    public function removeVacancy($id)
    {
        $rep = $this->getDoctrine()->getRepository(Vacancy::class);
        $vacancy = $rep->removeVacancy($id);
        dump($vacancy);
        die();
    }


    /**
    * @Route("/test/vacancies/find", name="test/vacancies/find")
    */
    public function getAllVacancies()
    {
        $rep = $this->getDoctrine()->getRepository(Vacancy::class);
        $vacancies = $rep->getAllVacancies();
        dump($vacancies);
        die();
    }

    /**
     * @Route("/test/vacancy/find/{id}", name="test/vacancy/findID")
     */
    public function getVacancyByID($id)
    {
        $rep = $this->getDoctrine()->getRepository(Vacancy::class);
        $vacancy = $rep->getVacancyByID($id);
        dump($vacancy);
        die();
    }

    /**
     * @Route("/test/vacancies/find/{user}", name="test/vacancies/findUser")
     */
    public function getVacanciesByUser($user)
    {
        $rep = $this->getDoctrine()->getRepository(Vacancy::class);
        $vacancies = $rep->getVacanciesByUser($user);
        dump($vacancies);
        die();
    }


    # APPLICATION FUNCTIONS TEST
    
    /**
    * @Route("/test/application", name="test/application")
    */
    public function saveApplication()
    {
        $params = array(
            "user_id" => 5,
            "vacancy_id" => 3,
            "application_date" => "2020-08-03",
            "invited" => false
        );

        $rep = $this->getDoctrine()->getRepository(Application::class);
        $application = $rep->saveApplication($params);
        dump($application);
        die();
    }

     /**
    * @Route("/test/application/remove/{id}", name="test/application/remove")
    */
    public function removeApplication($id)
    {
        $rep = $this->getDoctrine()->getRepository(Application::class);
        $application = $rep->removeApplication($id);
        dump($application);
        die();
    }

    /**
    * @Route("/test/applications/find", name="test/applications/find")
    */
    public function getAllApplications()
    {
        $rep = $this->getDoctrine()->getRepository(Application::class);
        $applications = $rep->getAllApplications();
        dump($applications);
        die();
    }

    /**
    * @Route("/test/application/find/{id}", name="test/application/findID")
    */
    public function getApplicationByID($id)
    {
        $rep = $this->getDoctrine()->getRepository(Application::class);
        $application = $rep->getApplicationByID($id);
        dump($application);
        die();
    }

    /**
    * @Route("/test/applications/find/{user}", name="test/application/findUser")
    */
    public function getApplicationsByUser($user)
    {
        $rep = $this->getDoctrine()->getRepository(Application::class);
        $application = $rep->getApplicationsByUser($user);
        dump($application);
        die();
    }
}
