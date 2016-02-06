<?php
namespace Acme\UsersBundle\MongoDB\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\UsersBundle\Document\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('admin');
        $user->setPassword('admin');
        $password = $this->container->get('security.password_encoder')
            ->encodePassword($user, $user->getPassword());
        $user->setPassword($password);
        $user->setRoles(array('ROLE_ADMIN'));

        $manager->persist($user);
        $manager->flush();

        for ($i = 1; $i <= 15; $i++) {
            $user = new User();
            $user->setName('name_'.uniqid());
            $user->setPassword(uniqid());
            $user->setRoles(array('ROLE_USER'));

            $manager->persist($user);
            $manager->flush();
        }
        
        
    }
}