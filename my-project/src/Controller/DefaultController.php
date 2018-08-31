<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $hitCounterService = $this->get('App\HitCounter');
        $currentHitCount = $hitCounterService->execute();

        return new Response(
            '<html><body>Your hit number: '.$currentHitCount.'</body></html>'
        );
    }
}