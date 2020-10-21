<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Service\ApplicationService;
use App\Service\UserService;
use App\Service\VacancyService;
use App\Service\PlatformService;

// The AdminController is used for all essential Admin-specific functions

    class AdminController extends AbstractController
    {
        /**
         * @Route("/admin/", name="admin")
         */
        public function index()
        {
            return $this->render('admin/index.html.twig', [
                'controller_name' => 'AdminController',
            ]);
        }

 
        /**
         * @Route("/admin/users/", name="admin/users")
         */
        public function showAllUsers(UserService $us)
        {
            $user = $this->getUser();

            if(in_array('ROLE_ADMIN', $user->getRoles()))
            {
                $users = $us->findAllUsers();
            
                return $this->render('admin/adminuser.html.twig', [
                    'controller_name' => 'AdminUsersController',
                    'user' => $user,
                    'users' => $users,]);
            }

            return new response('Access denied, you are not an admin');
        }

    // Function to render the Admin-Vacancies HTML-Twig file which will display table of all vacancies entered at VacIT

        /**
         * @Route("/admin/vacancies/", name="admin/vacancies")
         */
        public function showAllVacancies(VacancyService $vs)
        {
            $loggedin_user = $this->getUser();

            if(in_array('ROLE_ADMIN', $loggedin_user->getRoles()))
            {
                $vacancies = $vs->getAllVacancies();
            
                return $this->render('admin/adminvacancy.html.twig', [
                    'controller_name' => 'AdminUsersController',
                    'loggedin_user' => $loggedin_user,
                    'vacancies' => $vacancies,]);
            }

            return new response('Access denied, you are not an admin');
        }

    // Function to render the Admin-Applications HTML-Twig file which will display table of all applications entered at VacIT

        /**
         * @Route("/admin/applications/", name="admin/applications")
         */
        public function showAllApplications(ApplicationService $as)
        {
            $user = $this->getUser();

            if(in_array('ROLE_ADMIN', $user->getRoles()))
            {
                $applications = $as->getAllApplications();
                
                return $this->render('admin/adminapplication.html.twig', [
                    'controller_name' => 'AdminUsersController',
                    'user' => $user,
                    'applications' => $applications,]);
            }

            return new response('Access denied, you are not an admin');
        }

    // Function to render the Admin-Platforms HTML-Twig file which will display table of all available platforms entered at VacIT

        /**
         * @Route("/admin/platforms/", name="admin/platforms")
         */
        public function showAllPlatforms(PlatformService $ps)
        {
            $user = $this->getUser();

            if(in_array("ROLE_ADMIN", $user->getRoles()))
            {
                $platforms = $ps->getAllPlatforms();

                return $this->render('admin/adminplatform.html.twig', [
                    'controller_name' => 'AdminPlatformsController',
                    'user' => $user,
                    'platforms' => $platforms,]);
            }

            return new response('Access denied, you are not an admin');
        }

        /**
         * @Route("/admin/platform/save", name="admin/saveplatform")
         */
        public function savePlatform(Request $request, PlatformService $ps)
        {
            $user = $this->getUser();
            
            $params["id"] = $request->request->get("id");
            $params["name"] = $request->request->get("name");
            $params["icon_url"] = $request->request->get("icon_url");

            if(in_array("ROLE_ADMIN", $user->getRoles()))
            {
                $platforms = $ps->savePlatform($params);
                return $this->redirect("/admin/platforms/");
            }

            return new response('Access denied, you are not an admin');
        }

        /**
         * @Route("/admin/platforms/add", name="admin/addplatform")
         */
        public function addPlatform(PlatformService $ps)
        {
            $user = $this->getUser();

            if(in_array("ROLE_ADMIN", $user->getRoles()))
            {
                $platforms = $ps->getAllPlatforms();

                return $this->render('admin/admin-addplatform.html.twig', [
                    'controller_name' => 'AdminPlatformsController',
                    'user' => $user,
                    'platforms' => $platforms,]);
            }

            return new response('Access denied, you are not an admin');
        }

    }
