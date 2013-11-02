<?php

namespace Netgusto\Baikal\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\RedirectResponse;

class DavReroutingController extends Controller {

    public function propfindAction() {
        return new RedirectResponse($this->generateUrl("netgusto_baikal_dav_services_caldav"), 301); # 302
    }
}
