<?php

namespace Acme\DemoBundle\Controller;

use Mremi\ContactBundle\ContactEvents;
use Mremi\ContactBundle\Event\ContactEvent;
use Mremi\ContactBundle\Event\FilterContactResponseEvent;
use Mremi\ContactBundle\Event\FormEvent;
use Mremi\ContactBundle\Form\Factory\FormFactory;
use Mremi\ContactBundle\Model\ContactManagerInterface;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Acme\DemoBundle\Entity\Contact;

use Mremi\ContactBundle\Controller\ContactController as BaseController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as Controller;


class ContactController extends Controller
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var ContactManagerInterface
     */
    protected $contactManager;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var EngineInterface
     */
    protected $templating;
    
    /**
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher
     * @param \Mremi\ContactBundle\Form\Factory\FormFactory $formFactory
     * @param \Mremi\ContactBundle\Model\ContactManagerInterface $contactManager
     * @param \Symfony\Component\Routing\RouterInterface $router
     * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session
     * @param \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface $templating
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, FormFactory $formFactory, ContactManagerInterface $contactManager, RouterInterface $router, SessionInterface $session, EngineInterface $templating)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->formFactory     = $formFactory;
        $this->contactManager  = $contactManager;
        $this->router          = $router;
        $this->session         = $session;
        $this->templating      = $templating;
    }

    /**
     * Index action in charge to render the form
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response|RedirectResponse
     */
    public function indexAction(Request $request)
    {
        $contact = $this->contactManager->create();
        
        $this->eventDispatcher->dispatch(ContactEvents::FORM_INITIALIZE, new ContactEvent($contact, $request));

        $form = $this->formFactory->createForm($contact);

        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $event = new FormEvent($form, $request);

            $this->eventDispatcher->dispatch(ContactEvents::FORM_SUCCESS2, $event);
            
            if (null === $response = $event->getResponse()) {

                $response = new RedirectResponse($this->router->generate('contact_confirmation'));
            }

            $this->contactManager->save($contact, true);
            $this->session->set('mremi_contact_data', $contact);

            $this->eventDispatcher->dispatch(ContactEvents::FORM_COMPLETED, new FilterContactResponseEvent($contact, $request, $response));
            
            return $response;
        }

        return $this->templating->renderResponse('AcmeDemoBundle:Index:contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Confirm action in charge to render a confirmation message
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws AccessDeniedException If no contact stored in session
     */
    public function confirmAction()
    {
        $contact = $this->session->get('mremi_contact_data');

        if (!$contact) {
            throw new AccessDeniedException('Please fill the contact form');
        }

        return $this->templating->renderResponse('AcmeDemoBundle:Index:contact_confirmation.html.twig', array(
            'contact' => $contact,
        ));
    }
}
