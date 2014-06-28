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
class IndexController extends Controller
{
    /**
     * @return type
     */
    public function aproposAction(Request $request)
    {
        //$trans = $this->get('translator')->trans('Hello');
        
        $map = $this->get('ivory_google_map.map');
        
        $marker = new Marker();

        // Configure your marker options
        $marker->setPrefixJavascriptVariable('marker_');
        $marker->setPosition(36.745, 10.286, true);
        $marker->setAnimation(Animation::DROP);

        $marker->setOption('clickable', false);
        $marker->setOption('flat', true);
        $marker->setOptions(array(
                                    'clickable' => false,
                                    'flat'      => true,
                            ));
        
        $map->addMarker($marker);
        
        return $this->render('AcmeDemoBundle:Index:apropos.html.twig', array(
            "map" => $map
            ));
    }
    
    
    /**
     * 
     */
    public function setlanguageAction(Request $request)
    {
        $locale = $request->getLocale();
        
        $this->get('session')->set('_locale', $locale);

        return $this->redirect($this->generateUrl('apropos')) ;
    }
    
    /**
     * 
     */
    public function requestAction()
    {
        //$request = Request::create('https://wallet.paysera.com/rest/v1/server', 'GET', array()) ;
        
        //return new Response(var_dump($request));
        
        $browser = new Buzz\Browser();

        $response = $browser->get('http://www.google.com');
        
        return new Respnse($browser->getLastRequest());
    }
}