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

    /**
     * show register form
     * @return Response
     */
    public function registerAction() {
        $user = new User();
        $form = $this->createForm(new RegistrationType(), $user);
        //$form = $this->createForm(new RegistrationType(), new Registration());
        //but this do not work
        
        $form->handleRequest($this->getRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            $registration = $form->getData();

            $dm = $this->get('doctrine.odm.mongodb.document_manager');
            
            $user = $registration->getUser();
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            
            $dm->persist($user);
            $dm->flush();
            
            $this->addFlash(
                'notice',
                'User registered!'
            );

            return $this->redirectToRoute('acme_users_register');
        }
        
        return $this->render('AcmeUsersBundle:Users:register.html.twig', array('form' => $form->createView()));
    }

    /**
     * show create form
     * @return Response
     */
    public function createAction() {

        $user = new User();
        $form = $this->createForm(new EditType(), $user);

        $form->handleRequest($this->getRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            $registration = $form->getData();
            
            $user = $registration->getUser();
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $dm = $this->get('doctrine.odm.mongodb.document_manager');
            $dm->persist($user);
            $dm->flush();
            
            $this->addFlash(
                'notice',
                'User added!'
            );

            return $this->redirectToRoute('acme_users_show');
        }

        return $this->render('AcmeUsersBundle:Users:create.html.twig', array('form' => $form->createView()));
    }

    /**
     * show user list
     * @return Response
     */
    public function showAction() {
        $users = $this->get('doctrine_mongodb')
                ->getManager()
                ->getRepository('AcmeUsersBundle:User')
                ->findAllOrderedByName();
        return $this->render('AcmeUsersBundle:Users:show.html.twig', array('users' => $users));
    }
    
    /**
     * show users
     * @return Response
     */
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
            
            $user = $edit->getUser();
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $dm = $this->get('doctrine.odm.mongodb.document_manager');
            $dm->persist($user);
            $dm->flush();
            
            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );

            return $this->redirectToRoute('acme_users_show');
        }

        return $this->render('AcmeUsersBundle:Users:edit.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * delete users
     * @return Response
     */
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
