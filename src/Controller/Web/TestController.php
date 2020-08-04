<?php

namespace App\Controller\Web;

use App\Entity\Platform;

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
}
