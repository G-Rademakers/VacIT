<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use App\Service\UserService;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        $user = $this->getUser();
    
        if($user)
        {
            if(in_array('ROLE_CANDIDATE', $user->getRoles()))
            {
                
                return $this->render('user/applicant.html.twig', [
                'controller_name' => 'ApplicantController', 
                "user"=>$user,
                ]);
            }
        
            elseif(in_array('ROLE_EMPLOYER', $user->getRoles()))
            {
                return $this->render('user/employer.html.twig', [
                'controller_name' => 'EmployerController', 
                'user'=>$user,
                ]);
            } 
            
            else 
            {
                return new Response('Test when something else!');
            }
        } 
    } 

    /**
     * @Route("/userprofile/{id}", name="userprofile")
     */
    public function showUserProfile(UserService $us, $id)
    {
        $user = $this->getUser();

        if($user)
        {
            if(in_array('ROLE_CANDIDATE', $user->getRoles()))
            {
                $company = $us->findUserByID($id);

                if(in_array('ROLE_EMPLOYER', $company->getRoles()))
                {
                    return $this->render('user/employer.html.twig', [
                        'controller_name' => 'EmployerController', 
                        'user'=>$user,
                        'company'=>$company,
                    ]);
                }

                else
                {
                    return new response("No access to applicant profiles!");
                }
            }

            elseif(in_array('ROLE_EMPLOYER', $user->getRoles()))
            {
                $profile = $us->findUserByID($id);

                if(in_array('ROLE_EMPLOYER', $profile->getRoles()))
                {
                    return $this->render('user/employer.html.twig', [
                        'controller_name' => 'EmployerController', 
                        'user'=>$user,
                        'profile'=>$profile,
                    ]);
                }

                elseif(in_array('ROLE_CANDIDATE', $profile->getRoles()))
                {
                    return $this->render('user/applicant.html.twig', [
                        'controller_name' => 'ApplicantController', 
                        'user'=>$user,
                        'profile'=>$profile,
                    ]);
                }
            }

            else
            {
                return new response('User is not known');
            }
        }
    }
}
