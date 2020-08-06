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

    #PLATFORM FUNCTIONS TEST

    /**
     * @Route("/test", name="test")
     */
    public function index()
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    /**
     * @Route("/test/platform", name="test/platform")
     */
    public function SavePlatform()
    {
        $params = array(
            "id" => 2,
            "name" => "Windows",
            "icon_url" => ""
        );

        $rep = $this->getDoctrine()->getRepository(Platform::class);
        $platform = $rep->SavePlatform($params);
        dump($platform);
        die();
    }
    
    /**
     * @Route("/test/platform-removal/{id}", name="test/platform-removal")
     */
    public function RemovePlatform($id)
    {
        $rep = $this->getDoctrine()->getRepository(Platform::class);
        $platform = $rep->RemovePlatform($id);
        dump($platform);
        die();
    }

    
    /**
     * @Route("/test/findplatforms", name="test/platforms-find")
     */
    public function FindAllPlatforms()
    {
        $rep = $this->getDoctrine()->getRepository(Platform::class);
        $platform = $rep->FindAllPlatforms();
        dump($platform);
        die();
    }

    /**
    * @Route("/test/findplatform/{id}", name="test/platforms-find-id")
    */
    public function FindPlatform($id)
    {

        $rep = $this->getDoctrine()->getRepository(Platform::class);
        $platform = $rep->FindPlatformByID($id);
        dump($platform);
        die();
    }    





    
    # VACANCY FUNCTIONS TEST

    /**
     * @Route("/test/vacancy", name="test/vacancy")
     */
    public function SaveVacancy()
    {
        $params = array(
            "user_id" => 3,
            "platform_id" => 1,
            "function" => "Software Engineer",
            "level" => "Senior",
            "location" => "Eindhoven",
            "job_description" => "Experienced Software Engineer needed for the development of unique applications for daily use",
            "logo" => null
        );

        $rep = $this->getDoctrine()->getRepository(Vacancy::class);
        $vacancy = $rep->SaveVacancy($params);
        dump($vacancy);
        die();
    }



    /**
    * @Route("/test/findvacancies", name="test/findvacancies")
    */
    public function FindAllVacancies()
    {
        $rep = $this->getDoctrine()->getRepository(Vacancy::class);
        $vacancies = $rep->FindAllVacancies();
        dump($vacancies);
        die();
    }

    /**
     * @Route("/test/findvacancy/{id}", name="test/findvacancy")
     */
    public function FindVacancy($id)
    {
        $rep = $this->getDoctrine()->getRepository(Vacancy::class);
        $vacancy = $rep->FindVacancyByID($id);
        dump($vacancy);
        die();
    }

    /**
     * @Route("/test/vacancy-removal/{id}", name="test/vacancy-removal")
     */
    public function RemoveVacancy($id)
    {
        $rep = $this->getDoctrine()->getRepository(Vacancy::class);
        $vacancy = $rep->RemoveVacancy($id);
        dump($vacancy);
        die();
    }

    /**
     * @Route("/test/vacancies-find/{user}", name="test/vacancies-find-user")
     */
    public function FindVacanciesByUser($user)
    {
        $rep = $this->getDoctrine()->getRepository(Vacancy::class);
        $vacancies = $rep->FindVacanciesByUser($user);
        dump($vacancies);
        die();
    }




    # USER FUNCTIONS TEST

     /**
    * @Route("/test/findusers", name="test/users-find")
    */
    public function FindAllUsers()
    {
        $rep = $this->getDoctrine()->getRepository(User::class);
        $users = $rep->FindAllUsers();

        dump($users);
        die();
    }    

    /**
    * @Route("/test/finduser/{id}", name="test/platforms-find-id")
    */
    public function FindUser($id)
    {
        $rep = $this->getDoctrine()->getRepository(User::class);
        $user = $rep->FindUserById($id);

        dump($user);
        die();
    } 

    /**
    * @Route("/test/findusertype/{type}", name="test/users-find-type")
    */
    public function FindUsersByType($type)
    {
        $rep = $this->getDoctrine()->getRepository(User::class);
        $users = $rep->FindUsersByType($type);

        dump($users);
        die();
    }

    /**
    * @Route("/test/user", name="test/user")
    */
    public function SaveUser()
    {
        $params = array(
            "id" => 3,
            "first_name" => "Bob",
            "last_name" => "De Vries",
            "company_name" => "Frieze Vries",
            "address" => "Thialfstraat 56",
            "zipcode" => "1111",
            "city" => "Leeuwarden",
            "phone_number" => "0891111111",
            "date_of_birth" => "",
            "description" => "Oud Fries bedrijf dat op zoek is naar nieuwe potentiele werknemers.",
            "profile_picture_url" => "",
            "cv_url" => "",
            "type" => "C"
        );

        $rep = $this->getDoctrine()->getRepository(User::class);
        $user = $rep->SaveUser($params);
        dump($user);
        die();
    }
    
    /**
    * @Route("/test/remove-user/{id}", name="test/remove-user")
    */
    public function RemoveUser($id)
    {
        $rep = $this->getDoctrine()->getRepository(User::class);
        $user = $rep->RemoveUser($id);
        dump($user);
        die();
    }





     # APPLICATION FUNCTIONS TEST
    /**
    * @Route("/test/application", name="test/remove-user")
    */
    public function SaveApplication()
    {
        $params = array(
            "user_id" => 4,
            "vacancy_id" => 1,
            "application_date" => "2020-08-06",
            "invited" => false 
        );

        $rep = $this->getDoctrine()->getRepository(Application::class);
        $application = $rep->SaveApplication($params);
        dump($application);
        die();
    }
}
