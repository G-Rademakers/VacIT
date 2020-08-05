<?php

namespace App\Controller\Web;

use App\Entity\Platform;
use App\Entity\User;
use App\Entity\Vacancy;

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
            "user_id" => 2,
            "platform_id" => 1,
            "function" => "Software Developer",
            "level" => "Junior",
            "location" => "Sittard",
            "job_description" => "Challenging position as a junior software developer at Baker IT",
            "logo" => null
        );

        $rep = $this->getDoctrine()->getRepository(Vacancy::class);
        $vacancy = $rep->SaveVacancy($params);
        dump($vacancy);
        die();
    }



    /**
    * @Route("/test/findvacansies", name="test/findvacancies")
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



    // /**
    // * @Route("/test/findusers", name="test/users-find")
    // */
    // public function FindAllUsers()
    // {
    //     $rep = $this->getDoctrine()->getRepository(User::class);
    //     $users = $rep->FindAllUsers();

    //     dump($users);
    //     die();
    // }    

    // /**
    // * @Route("/test/finduser/{id}", name="test/platforms-find-id")
    // */
    // public function FindUser($id)
    // {

    //     $rep = $this->getDoctrine()->getRepository(User::class);
    //     $user = $rep->FindUserById($id);

    //     dump($user);
    //     die();
    // }    
}
