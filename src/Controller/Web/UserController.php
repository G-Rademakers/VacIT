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
            if(in_array('ROLE_CANDIDATE', $user->getRoles()) or in_array('ROLE_ADMIN', $user->getRoles()))
            {
                
                return $this->render('user/applicant.html.twig', [
                'controller_name' => 'ApplicantController', 
                "user"=>$user]);
            }
        
            elseif(in_array('ROLE_EMPLOYER', $user->getRoles()) or in_array('ROLE_ADMIN', $user->getRoles()))
            {
                return $this->render('user/employer.html.twig', [
                'controller_name' => 'EmployerController', 
                'user'=>$user]);
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
            if(in_array('ROLE_CANDIDATE', $user->getRoles()) or in_array('ROLE_ADMIN', $user->getRoles()))
            {
                $company = $us->findUserByID($id);

                if(in_array('ROLE_EMPLOYER', $company->getRoles()))
                {
                    return $this->render('user/employer.html.twig', [
                        'controller_name' => 'EmployerController', 
                        'user'=>$user,
                        'company'=>$company]);
                }

                else
                {
                    return new response("No access to applicant profiles!");
                }
            }

            elseif(in_array('ROLE_EMPLOYER', $user->getRoles()) or in_array('ROLE_ADMIN', $user->getRoles()))
            {
                $profile = $us->findUserByID($id);

                if(in_array('ROLE_EMPLOYER', $profile->getRoles()))
                {
                    return $this->render('user/employer.html.twig', [
                        'controller_name' => 'EmployerController', 
                        'user'=>$user,
                        'profile'=>$profile]);
                }

                elseif(in_array('ROLE_CANDIDATE', $profile->getRoles()))
                {
                    return $this->render('user/applicant.html.twig', [
                        'controller_name' => 'ApplicantController', 
                        'user'=>$user,
                        'profile'=>$profile]);
                }
            }

            else
            {
                return new response('User is not known');
            }
        }
    }

     /**
     * @Route("/userprofile/edit/{id}", name="edit/userprofile")
     */
    public function editUserProfile(UserService $us, $id)
    {
        $user = $this->getUser();
        $user_confirmation = $us->findUserByID($id);
        $params = array(
            "id" => 15,
            "first_name" => "Christel",
            "last_name" => "Rademakers",
            "company_name" => "",
            "address" => "Beekstraat 4",
            "zipcode" => "6451CD",
            "city" => "Schinveld",
            "phone_number" => "032452313",
            "date_of_birth" => "1959-03-10",
            "description" => "Nieuwe Uitdaging etc",
            "profile_picture_url" => "",
            "cv_url" => "",
            "type" => "A"
        );
     
        if($user == $user_confirmation or in_array('ROLE_ADMIN', $user->getRoles()))
        {
            if($id == $params['id'])
            {
                $result = $us->saveUser($params);
                return $this->render('user/edit.html.twig', [
                    'controller_name' => 'ApplicantController', 
                    'user'=>$user]);
            }
        }
        
        else
        {
            return new response('No access to this profile');
        }
    }

     /**
     * @Route("/userprofile/remove/{id}", name="remove/userprofile")
     */
    public function RemoveUserProfile(UserService $us, $id)
    {
        $user = $this->getUser();
        $user_confirmation = $us->findUserByID($id);
     
        if($user == $user_confirmation or in_array('ROLE_ADMIN', $user->getRoles()))
        {
            $result = $us->deleteUser($id);
            return $this->render('user/delete.html.twig', [
                'controller_name' => 'DeleteController', 
                'user'=>$user,
                'user_confirmation'=>$user_confirmation,
                'result'=>$result]);
        }

        else
        {
            return new response('No permission to delete this account');
        }
    }
}
