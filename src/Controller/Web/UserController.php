<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

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
    return new response('Your Profile has been updated!');  
    }

     /**
     * @Route("/userprofile/save/{id}", name="save/userprofile")
     */
    public function saveUserProfile(Request $request, UserService $us, $id)
    {
        $user = $this->getUser();
        $user_confirmation = $us->findUserByID($id);

        $params["id"] = $id;
        $params["first_name"] = $request->request->get("first_name");
        $params["last_name"] = $request->request->get("last_name");
        $params["company_name"] = $request->request->get("company_name");
        $params["address"] = $request->request->get("address");
        $params["zipcode"] = $request->request->get("zipcode");
        $params["city"] = $request->request->get("city");
        $params["phone_number"] = $request->request->get("phone_number");
        $params["description"] = $request->request->get("description");
        $params["date_of_birth"] = $request->request->get("date_of_birth");
        
        if($user == $user_confirmation or in_array('ROLE_ADMIN', $user->getRoles()))
        {
            if($id == $params['id'])
            {
                $result = $us->saveUser($params);
                return $this->redirect("/login/");
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
