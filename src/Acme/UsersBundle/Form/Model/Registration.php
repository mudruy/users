<?php

namespace Acme\UsersBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use Acme\UsersBundle\Document\User;

class Registration
{
    /**
     * @Assert\Type(type="Acme\UsersBundle\Document\User")
     */
    protected $user;


    public function setUser(Acme\UsersBundle\Document\User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

}