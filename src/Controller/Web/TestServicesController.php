<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\VacancyService;
use App\Entity\Vacancy;

use App\Service\PlatformService;
use App\Entity\Platform;

use App\Service\ApplicationService;
use App\Entity\Application;

use App\Service\UserService;
use App\Entity\User;

class TestServicesController extends AbstractController
{
    /**
     * @Route("/test/services", name="test_services")
     */
    public function index()
    {
        return $this->render('test_services/index.html.twig', [
            'controller_name' => 'TestServicesController',
        ]);
    }

### VACANCIES - SERVICE FUNCTIONS

    /**
     * @Route("/test/services/vacancies", name="test_services_GetAllVacancies")
     */
    public function getAllVacancies(VacancyService $vs)
    {
        $vacancies = $vs->getAllVacancies();
        dump($vacancies);
        die();
    }

     /**
     * @Route("/test/services/vacancy/{id}", name="test_services_GetVacancyByID")
     */
    public function getVacancyByID(VacancyService $vs, $id)
    {
        $vacancy = $vs->getVacancyByID($id);
        dump($vacancy);
        die();
    }

     /**
     * @Route("/test/services/vacancies-user/{user}", name="test_services_GetVacanciesByUser")
     */
    public function getVacanciesByUser(VacancyService $vs, $user)
    {
        $vacancies = $vs->getVacanciesByUser($user);
        dump($vacancies);
        die();
    }

     /**
     * @Route("/test/services/vacancy/save", name="test_services_SaveVacancy")
     */
    public function saveVacancy(VacancyService $vs, $params)
    {
        $vacancy = $vs->saveVacancy($params);
        dump($vacancy);
        die();
    }

     /**
     * @Route("/test/services/vacancy/remove/{id}", name="test_services_RemoveVacancy")
     */
    public function removeVacancy(VacancyService $vs, $id)
    {
        $vacancy = $vs->removeVacancy($id);
        dump($vacancy);
        die();
    }

      /**
    * @Route("/test/services/vacancies/findmostrecent/", name="test/vacancies")
    */
    public function getRecentVacancies(VacancyService $vs)
    {
        $vacancies = $vs->getRecentVacancies();
        dump($vacancies);
        die();
    }

### PLATFORMS - SERVICE FUNCTIONS

    /**
     * @Route("/test/services/platforms", name="test_services_GetAllPlatforms")
     */
    public function getAllPlatforms(PlatformService $ps)
    {
        $platforms = $ps->getAllPlatforms();
        dump($platforms);
        die();
    }

     /**
     * @Route("/test/services/platform/{id}", name="test_services_GetPlatform")
     */
    public function getPlatformByID(PlatformService $ps, $id)
    {
        $platform = $ps->getPlatformByID($id);
        dump($platform);
        die();
    }

    /**
     * @Route("/test/services/platform/save", name="test_services_SavePlatform")
     */
    public function savePlatform(PlatformService $ps, $params)
    {
        $platform = $ps->getPlatformByID($params);
        dump($platform);
        die();
    }

     /**
     * @Route("/test/services/platform/remove/{id}", name="test_services_removePlatform")
     */
    public function removePlatform(PlatformService $ps, $id)
    {
        $platform = $ps->removePlatform($id);
        dump($platform);
        die();
    }

### APPLICATIONS - SERVICE FUNCTIONS
    
     /**
     * @Route("/test/services/applications", name="test_services_GetAllApplications")
     */
    public function getAllApplications(ApplicationService $as)
    {
        $applications = $as->getAllApplications();
        dump($applications);
        die();
    }

     /**
     * @Route("/test/services/application/{id}", name="test_services_GetApplication")
     */
    public function getApplicationByID(ApplicationService $as, $id)
    {
        $application = $as->getApplicationByID($id);
        dump($application);
        die();
    }
    
    /**
     * @Route("/test/services/applications/{user}", name="test_services_GetApplicationByUsers")
     */
    public function getApplicationsByUser(ApplicationService $as, $user)
    {
        $applications = $as->getApplicationsByUser($user);
        dump($applications);
        die();
    }

    /**
     * @Route("/test/services/applications/save", name="test_services_SaveApplication")
     */
    public function saveApplication(ApplicationService $as, $params)
    {   
        $application = $as->saveApplication($params);
        dump($application);
        die();
    }

    /**
     * @Route("/test/services/application/remove/{id}", name="test_services_removeApplication")
     */
    public function removeApplication(ApplicationService $as, $id)
    {
        $application = $as->removeApplication($id);
        dump($application);
        die();
    }

     /**
     * @Route("/test/services/application/vacancy/{vacancy}", name="test_services_VacancyApplication")
     */
    public function getApplicationsByVacancyID(ApplicationService $as, $vacancy)
    {
        $applications = $as->getApplicationsByVacancy($vacancy);
        dump($applications);
        die();
    }

    
     /**
     * @Route("/test/services/application/interest/{id}", name="test_services_InterestApplication")
     */
    public function switchInterest(ApplicationService $as, $id)
    {
        $application = $as->switchInterest($id);
        dump($application);
        die();
    }

### USERS - SERVICE FUNCTIONS

     /**
     * @Route("/test/services/user/create", name="test_services_CreateUser")
     */
    public function CreateUser(UserService $us)
    {
        $params = array(
            "username" => "Testen",
            "password" => "Testen",
            "roles" => "ROLE_CANDIDATE",
            "email" => "testen@test.nl"
        );

        $user = $us->createUser($params);
        dump($user);
        die();
    }

     /**
     * @Route("/test/services/user/save", name="test_services_saveUser")
     */
    public function saveUser(UserService $us)
    {
        $params = array(
            "id" => 8,
            "first_name" => "Glenn",
            "last_name" => "Rademakers",
            "company_name" => "",
            "address" => "Beekstraat 2",
            "zipcode" => "6451 CC",
            "city" => "Schinveld",
            "phone_number" => "0654617099",
            "date_of_birth" => "02-08-1991",
            "description" => "Ambitious scientist looking to expand his skills within the IT sector",
            "profile_picture_url" => "",
            "cv_url" => "",
            "type" => "A"
        );

        $user = $us->saveUser($params);
        dump($user);
        die();           
    }

    /**
     * @Route("/test/services/user/delete/{id}", name="test_services_removeUser")
     */
    public function deleteUser(UserService $us, $id)
    {
        $user = $us->deleteUser($id);
        dump($user);
        die();
    }
        
    /**
     * @Route("/test/services/user/get/{id}", name="test_services_getUser")
     */
    public function findUser(UserService $us, $id)
    {
        $user = $us->findUser($id);
        dump($user);
        die();
    }   

     /**
     * @Route("/test/services/users/get", name="test_services_getUser")
     */
    public function findAllUsers(UserService $us)
    {
        $users = $us->findAllUsers();
        dump($users);
        die();
    }

     /**
     * @Route("/test/services/user/getusername/{name}", name="test_services_getUser")
     */
    public function findUserByName(UserService $us, $name)
    {
        $user = $us->findUserByName($name);
        dump($user);
        die();
    }

    //  /**
    //   * @Route("/test/services/user/get/{type}", name="test_services_getUser")
    //   */
    // public function findAllUsersByRole(UserService $us, $type)
    // {
    //     $users = $us->findUsersByRole($type);
    //     dump($users);
    //     die();
    // }
}
