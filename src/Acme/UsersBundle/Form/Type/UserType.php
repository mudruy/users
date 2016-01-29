<?php

namespace Acme\UsersBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class);
        $builder->add('password', 'repeated', array(
           'first_name' => 'password',
           'second_name' => 'confirm',
           'type' => 'password'
        ));
//        $builder->add('groups', 'entity',
//            array(
//                'class' => '\Acme\UsersBundle\Document\Group',
//                'label' => 'User Group',
//            )
//        );
    }

    public function getDefaultOptions(array $options)
    {
        return array('data_class' => 'Acme\UsersBundle\Document\User');
    }

    public function getName()
    {
        return 'user';
    }
}