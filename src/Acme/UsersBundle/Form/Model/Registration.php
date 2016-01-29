<?php

namespace Acme\UsersBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use Acme\UsersBundle\Document\User;

class Registration
{
    /**
     * @Assert\Type(type="Acme\AccountBundle\Document\User")
     */
    protected $user;

    /**
     * @Assert\NotBlank()
     * @Assert\True()
     */
    protected $termsAccepted;
    
    public function __construct()
	{
		$this->user = new User();
	}

    public function setUser( $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getTermsAccepted()
    {
        return $this->termsAccepted;
    }

    public function setTermsAccepted($termsAccepted)
    {
        $this->termsAccepted = (boolean)$termsAccepted;
    }

}