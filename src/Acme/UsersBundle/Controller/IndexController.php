<?php

namespace Acme\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\UsersBundle\Document\User;
use Acme\UsersBundle\Document\Group;
use Symfony\Component\HttpFoundation\Response;
use Acme\UsersBundle\Form\Type\RegistrationType;
use Acme\UsersBundle\Form\Type\EditType;
use Acme\UsersBundle\Form\Type\UserType;
use Acme\UsersBundle\Form\Model\Registration;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class IndexController extends Controller {

    public function indexAction() {
        return $this->redirectToRoute('acme_users_show');
    }

    public function registerAction() {
        $form = $this->createForm(new RegistrationType(), new Registration());
        return $this->render('AcmeUsersBundle:Users:register.html.twig', array('form' => $form->createView()));
    }

    public function createAction() {

        $user = new User();
        $form = $this->createForm(new RegistrationType(), $user);
        //$form = $this->createForm(new RegistrationType(), new Registration());
        //but this do not work

        $form->handleRequest($this->getRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            $registration = $form->getData();

            $dm = $this->get('doctrine.odm.mongodb.document_manager');
            $dm->persist($registration->getUser());
            $dm->flush();

            return $this->redirectToRoute('acme_users_show');
        }

        return $this->render('AcmeUsersBundle:Users:register.html.twig', array('form' => $form->createView()));
    }

    public function showAction() {
        $users = $this->get('doctrine_mongodb')
                ->getManager()
                ->getRepository('AcmeUsersBundle:User')
                ->findAllOrderedByName();
        return $this->render('AcmeUsersBundle:Users:show.html.twig', array('users' => $users));
    }
    
    public function editAction() {

        $user = $this->get('doctrine_mongodb')
                ->getManager()
                ->getRepository('AcmeUsersBundle:User')
                ->findUserById($this->getRequest()->get('id'));
        
        if(empty($user)){
            $this->createNotFoundException('The user does not exist');
        }
        
        $form = $this->createForm(new EditType(), $user);
        $form->handleRequest($this->getRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            $edit = $form->getData();

            $dm = $this->get('doctrine.odm.mongodb.document_manager');
            $dm->persist($edit->getUser());
            $dm->flush();
            
            $this->addFlash(
                'notice',
                'Your changes were saved!'
        )   ;

            return $this->redirectToRoute('acme_users_show');
        }

        return $this->render('AcmeUsersBundle:Users:edit.html.twig', array('form' => $form->createView()));
    }
    
    public function deleteAction() {
        $user = $this->get('doctrine_mongodb')
                ->getManager()
                ->getRepository('AcmeUsersBundle:User')
                ->findUserById($this->getRequest()->get('id'));
        if(empty($user)){
            $this->createNotFoundException('The user does not exist');
        }
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $dm->remove($user);
        $dm->flush();
        
        $this->addFlash(
            'notice',
            'User deleted!'
        );
        return $this->redirectToRoute('acme_users_show');

    }

}
