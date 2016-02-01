<?php

namespace Acme\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\UsersBundle\Document\User;
use Acme\UsersBundle\Form\Type\RegistrationType;

class RegisterController extends Controller {

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
            $user->setRoles(array("ROLE_USER"));
            
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

}
