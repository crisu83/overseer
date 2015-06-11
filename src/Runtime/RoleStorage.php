<?php namespace Crisu83\Overseer\Runtime;

use Crisu83\Overseer\Entity\Role;
use Crisu83\Overseer\Exception\RoleNotFound;

class RoleStorage implements \Crisu83\Overseer\Storage\RoleStorage
{

    /**
     * @var Role[]
     */
    private $roles;


    /**
     * RoleStorage constructor.
     */
    public function __construct()
    {
        $this->roles = [];
    }


    /**
     * @inheritdoc
     */
    public function saveRole(Role $role)
    {
        $this->roles[$role->getName()] = $role;
    }


    /**
     * @inheritdoc
     */
    public function getRole($name)
    {
        return isset($this->roles[$name]) ? $this->roles[$name] : null;
    }
}
