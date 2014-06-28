<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Acme\DemoBundle\Entity\Contact;

use Ivory\GoogleMap\Overlays\Animation;
use Ivory\GoogleMap\Overlays\Marker;

/**
 * Index controller.
 *
 */
class ExceptionController extends Controller
{
    /**
     * @return type
     */
    public function exceptionAction(Request $request)
    {
        return $this->render('AcmeDemoBundle:Index:exception.html.twig', array());
    }
}