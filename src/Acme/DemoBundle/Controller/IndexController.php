<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Acme\DemoBundle\Entity\Contact;

use Ivory\GoogleMap\Overlays\Animation;
use Ivory\GoogleMap\Overlays\Marker;

use Acme\DemoBundle\Entity\Article;
use Acme\DemoBundle\Entity\Commentaire;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;

use Ob\HighchartsBundle\Highcharts\Highchart;

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
    public function testAction(Request $request)
    {
        return new Response("hello");
    }
    
    /**
     * 
     */
    public function articleAction()
    {
        
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('AcmeDemoBundle:Article')->findAll();
        
        if (!$articles) {
            throw $this->createNotFoundException('There is no articles');
        }

        return $this->render('AcmeDemoBundle:Index:article.html.twig', array(
            'articles' => $articles
        ));
    }
    
    public function chartAction()
    {

    $series = array(
        array("name" => "Data Serie Name",    "data" => array(1,2,4,5,6,3,8))
    );

    $ob = new Highchart();
    $ob->chart->renderTo('linechart');  // The #id of the div where to render the chart
    $ob->title->text('Chart Title');
    $ob->xAxis->title(array('text'  => "Horizontal axis title"));
    $ob->yAxis->title(array('text'  => "Vertical axis title"));
    $ob->series($series);

    return $this->render('AcmeDemoBundle:Index:charts.html.twig', array(
        'chart' => $ob
    ));
    }
}