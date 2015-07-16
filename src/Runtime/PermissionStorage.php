<?php namespace Crisu83\Overseer\Runtime;

use Crisu83\Overseer\Entity\Permission;

class PermissionStorage implements \Crisu83\Overseer\Storage\PermissionStorage
{

    /**
     * @var Permission[]
     */
    private $permissions;


    /**
     * RoleStorage constructor.
     */
    public function __construct()
    {
        $this->permissions = [];
    }


    /**
     * @inheritdoc
     */
    public function savePermission(Permission $permission)
    {
        $this->permissions[$permission->getName()] = $permission;
    }


    /**
     * @inheritdoc
     */
    public function getPermission($name)
    {
        return isset($this->permissions[$name]) ? $this->permissions[$name] : null;
    }


    /**
     * @inheritdoc
     */
    public function clearPermissions()
    {
        $this->permissions = [];
    }
}
