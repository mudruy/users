<?php

namespace Acme\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\UsersBundle\Document\User;
use Acme\UsersBundle\Document\Group;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AcmeUsersBundle:Default:index.html.twig');
    }
    
    public function createAction()
    {
        $group = $this->get('doctrine_mongodb')
            ->getManager()
            ->getRepository('AcmeUsersBundle:Group')
            ->getDefaultGroup();
        
        
        $user = new User();
        $user->setName('user2');
        $user->setPassword('19.99');
        $user->setGroup($group);
        
       

        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $dm->persist($user);
        $dm->flush();

        return new Response('Created product id '.$user->getId());
    }
    
}
