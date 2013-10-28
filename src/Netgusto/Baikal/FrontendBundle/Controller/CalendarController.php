<?php

namespace Netgusto\Baikal\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends Controller
{
    public function listAction()
    {
        return $this->render('NetgustoBaikalFrontendBundle:Calendar:list.html.twig');
    }
}
