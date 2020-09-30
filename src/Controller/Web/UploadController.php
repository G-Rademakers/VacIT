<?php

namespace App\Controller\Web;

use App\Library\FileUpload;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UploadController extends AbstractController
{
   
    ///// LET OP!! De Library FileUpload wordt hier gebruikt!
    ///// Deze altijd in combinatie met SimpleUploader gebruiken!

    /**
     * @Route("/upload", name="upload_file")
     */
    public function uploadFile(Request $request) {

        /// Dit bijvoorkeur uit je .env halen!
        $path = "upload/";

        $file_id = uniqid();
        $uploader = new FileUpload('file');
        $uploader->newFileName =  $file_id . "-" . strtolower(str_replace(" ", "-", $uploader->getFileName()));
        $result = $uploader->handleUpload("$path");

        /// Voor afbeeldingen
        // list($w, $h) = getimagesize($path . $uploader->newFileName);

        if (!$result) {
            $v = json_encode(['success' => false, 'errors' => $uploader->getErrorMsg()]);
        } else {

            $v = json_encode(['success' => true, 
                              'file_id' => $path . $uploader->newFileName ]);
        }

        $response= new Response($v);
        $response->headers->set('Content-Type','application/json');
        return($response);
    }

    

}
