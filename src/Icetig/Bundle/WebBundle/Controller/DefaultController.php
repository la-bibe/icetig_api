<?php

namespace Icetig\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $response = $this->render('WebBundle:Default:index.html.twig');
        return $response;
    }
}
