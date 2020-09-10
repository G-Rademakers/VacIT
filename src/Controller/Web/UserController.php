<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use App\Service\UserService;

class UserController extends AbstractController
{
    /**
     * @Route("/userprofile/show/{id}", name="show/userprofile")
     */
    public function showUserProfile(UserService $us, $id)
    {
        $user = $this->getUser();

        if($user)
        {
            $profile = $us->findUserByID($id);

            if(in_array('ROLE_EMPLOYER', $profile->getRoles()))
            {
                return $this->render('user/employer.html.twig', [
                    'controller_name' => 'EmployerController', 
                    'user'=>$user,
                    'profile'=>$profile]);
            }

            else
            {
                return $this->render('user/applicant.html.twig', [
                    'controller_name' => 'ApplicantController', 
                    'user'=>$user,
                    'profile'=>$profile]);
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

        if($user == $user_confirmation)
        {
            $profile = $us->findUserByID($id);

            if(in_array('ROLE_EMPLOYER', $profile->getRoles()))
            {
                return $this->render('user/edit.html.twig', [
                    'controller_name' => 'EmployerController', 
                    'user'=>$user,
                    'profile'=>$profile]);
            }

            else
            {
                return $this->render('user/edit.html.twig', [
                    'controller_name' => 'ApplicantController', 
                    'user'=>$user,
                    'profile'=>$profile]);
            }
        }
    }

     /**
     * @Route("/userprofile/save/{id}", name="save/userprofile")
     */
    public function saveUserProfile(UserService $us, $id)
    {
        $user = $this->getUser();
        $user_confirmation = $us->findUserByID($id);
        $params[] = array();
        //     "id" => $id,
        //     "first_name" => "Glenn",
        //     "last_name" => "Rademakers",
        //     "company_name" => "",
        //     "address" => "Beekstraat 2",
        //     "zipcode" => "6451CC",
        //     "city" => "Schinveld",
        //     "phone_number" => "0654617099",
        //     "date_of_birth" => "1991-08-02",
        //     "description" => "Hier komt wederom een lang verhaal over ideeen, dromen en toekomst",
        //     "profile_picture_url" => "",
        //     "cv_url" => "",
        //     "type" => "A"
        // );
     
        if($user == $user_confirmation or in_array('ROLE_ADMIN', $user->getRoles()))
        {
            if($id == $params['id'])
            {
                $result = $us->saveUser($params);
                return $this->render('user/save.html.twig', [
                    'controller_name' => 'ApplicantController', 
                    'user'=>$user]);
            }
        }
        
        else
        {
            return new response('No access to this profile');
        }

        return new response('Something went wrong');
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
