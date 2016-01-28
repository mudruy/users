<?php

namespace Acme\UsersBundle\Document;

class Group
{
    /** @ReferenceOne(targetDocument="User") */
    private $user;
    
    
    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     */
    protected $role;

    /**
     * @var MongoId $id
     */
    protected $id;


    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set role
     *
     * @param string $role
     * @return self
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * Get role
     *
     * @return string $role
     */
    public function getRole()
    {
        return $this->role;
    }
}
