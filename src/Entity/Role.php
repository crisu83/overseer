<?php namespace Crisu83\Overseer\Entity;

use Crisu83\Overseer\Exception\PropertyNotValid;

class Role
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var array
     */
    private $permissions;


    /**
     * Permission constructor.
     *
     * @param string $roleName
     * @param array  $roles
     * @param array  $permissions
     */
    public function __construct($roleName, array $roles = [], array $permissions = [])
    {
        $this->setName($roleName);
        $this->setRoles($roles);
        $this->setPermissions($permissions);
    }


    /**
     * @param string $roleName
     *
     * @throws PropertyNotValid
     */
    public function inheritRole($roleName)
    {
        if (empty($roleName)) {
            throw new PropertyNotValid('Role name cannot be empty.');
        }

        if ($roleName === $this->getName()) {
            throw new PropertyNotValid('Role cannot be added to itself.');
        }

        if ($this->hasRole($roleName)) {
            return;
        }

        $this->roles[] = $roleName;
    }


    /**
     * @param string $permissionName
     *
     * @throws PropertyNotValid
     */
    public function addPermission($permissionName)
    {
        if (empty($permissionName)) {
            throw new PropertyNotValid('Permission name cannot be empty.');
        }

        if ($this->hasPermission($permissionName)) {
            return;
        }

        $this->permissions[] = $permissionName;
    }


    /**
     * @return bool
     */
    public function hasRoles()
    {
        return !empty($this->roles);
    }


    /**
     * @return bool
     */
    public function hasPermissions()
    {
        return !empty($this->permissions);
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }


    /**
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }


    /**
     * @param string $roleName
     *
     * @return bool
     */
    private function hasRole($roleName)
    {
        return in_array($roleName, $this->roles);
    }


    /**
     * @param string $permissionName
     *
     * @return bool
     */
    private function hasPermission($permissionName)
    {
        return in_array($permissionName, $this->permissions);
    }


    /**
     * @param string $name
     *
     * @throws PropertyNotValid
     */
    private function setName($name)
    {
        if (empty($name)) {
            throw new PropertyNotValid('Role name cannot be empty.');
        }

        $this->name = $name;
    }


    /**
     * @param array $roles
     */
    private function setRoles($roles)
    {
        $this->roles = $roles;
    }


    /**
     * @param array $permissions
     */
    private function setPermissions($permissions)
    {
        $this->permissions = $permissions;
    }
}
