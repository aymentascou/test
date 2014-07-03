<?php

namespace Acme\DemoBundle\Entity;

use Mremi\ContactBundle\Model\Contact as BaseContact;
use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Acme\DemoBundle\Entity\ContactRepository")
 */
class Contact extends BaseContact
{   
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="titre", type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @var string
     * 
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    protected $firstName;

    /**
     * @var string
     * 
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    protected $lastName;

    /**
     * @var string
     * 
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    protected $email;

    /**
     * @var string
     * 
     * @ORM\Column(name="subject", type="string", length=255, nullable=true)
     */
    protected $subject;

    /**
     * @var string
     * 
     * @ORM\Column(name="message", type="string", length=255, nullable=true)
     */
    protected $message;
    
    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="createAt", type="datetime", nullable=true)
     */
    protected $createdAt;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
}
