<?php

namespace Acme\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * 
     * @param Request $request
     * @return template
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'AcmeUsersBundle:security:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }

    /**
     * 
     */
    public function loginCheckAction()
    {
        return $this->redirectToRoute('acme_users_show');
//        echo $this->getRequest()->get('_username');
//        echo $this->getRequest()->get('_password');
//        die('123');
        // this controller will not be executed,
        // as the route is handled by the Security system
    }
}