<?php namespace Crisu83\Overseer\Entity;

use Crisu83\Overseer\Exception\InvalidArgument;

class Role
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $permissions = [];


    /**
     * Permission constructor.
     *
     * @param string $roleName
     */
    public function __construct($roleName)
    {
        $this->setName($roleName);
    }


    /**
     * @param string $permissionName
     */
    public function addPermission($permissionName)
    {
        if (empty($permissionName)) {
            throw new InvalidArgument('Permission name cannot be empty.');
        }

        $this->permissions[] = $permissionName;
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
    public function getPermissions()
    {
        return $this->permissions;
    }


    /**
     * @param string $name
     *
     * @throws InvalidArgument
     */
    private function setName($name)
    {
        if (empty($name)) {
            throw new InvalidArgument('Role name cannot be empty.');
        }

        $this->name = $name;
    }
}
