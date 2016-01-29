<?php

namespace Acme\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\UsersBundle\Document\User;
use Acme\UsersBundle\Document\Group;
use Symfony\Component\HttpFoundation\Response;

use Acme\UsersBundle\Form\Type\RegistrationType;
use Acme\UsersBundle\Form\Type\UserType;
use Acme\UsersBundle\Form\Model\Registration;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AcmeUsersBundle:Default:index.html.twig');
    }
    
    public function create2Action()
    {
        $group = $this->get('doctrine_mongodb')
            ->getManager()
            ->getRepository('AcmeUsersBundle:Group')
            ->getDefaultGroup();
        
        
        $user = new User();
        $user->setName('user2');
        $user->setPassword('19.99');
        
       

        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $dm->persist($user);
        $dm->flush();

        return new Response('Created product id '.$user->getId());
    }
    
    
    public function registerAction()
    {
        $form = $this->createForm(new RegistrationType(), new Registration());
        return $this->render('AcmeUsersBundle:Users:register.html.twig', array('form' => $form->createView()));
    }
    
    public function createAction()
    {   
        $dm = $this->get('doctrine.odm.mongodb.document_manager');

        $user = new User();
        $form = $this->createForm(new RegistrationType(), $user);
        //$form = $this->createForm(new RegistrationType(), new Registration());
        //but this do not work

        $form->handleRequest($this->getRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            $registration = $form->getData();

            $dm->persist($registration->getUser());
            $dm->flush();

            return $this->redirectToRoute('acme_users_register');
        }

        return $this->render('AcmeUsersBundle:Users:register.html.twig', array('form' => $form->createView()));
    }
    
}
