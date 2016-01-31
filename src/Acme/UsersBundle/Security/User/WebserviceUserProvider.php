<?php

namespace Acme\UsersBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Acme\UsersBundle\Repository\UserRepository;
use Acme\UsersBundle\Security\User\WebserviceUser;


class WebserviceUserProvider  implements UserProviderInterface
{
    protected $_user_repository;

    /**
     * 
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository) {
        $this->_user_repository = $repository;
    }

    /**
     * custom user find
     * @param string $username
     * @return WebserviceUser
     * @throws UsernameNotFoundException
     */
    public function loadUserByUsername($username)
    {
        $userData = $this->_user_repository->findUserByName($username);


        if ($userData instanceof \Acme\UsersBundle\Document\User) {
            return new WebserviceUser($userData->getUsername(), $userData->getPassword(), '', $userData->getRoles());
        }

        throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
        );
    }

    /**
     * 
     * @param UserInterface $user
     * @return WebserviceUser
     * @throws UnsupportedUserException
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * 
     * @param string $class
     * @return boolean
     */
    public function supportsClass($class)
    {
        return $class === 'Acme\UsersBundle\Security\User\WebserviceUser';
    }
}