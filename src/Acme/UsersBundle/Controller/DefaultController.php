<?php

namespace Acme\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AcmeUsersBundle:Default:index.html.twig');
    }
}
