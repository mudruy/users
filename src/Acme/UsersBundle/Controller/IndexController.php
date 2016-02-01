<?php

namespace Acme\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\UsersBundle\Document\User;
use Acme\UsersBundle\Form\Type\RegistrationType;
use Acme\UsersBundle\Form\Type\EditType;
use Acme\UsersBundle\Form\Model\Registration;

class IndexController extends Controller {

    public function indexAction() {
        return $this->redirectToRoute('acme_users_show');
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
