<?php namespace Crisu83\Overseer\Storage;

use Crisu83\Overseer\Entity\Role;

interface RoleStorage
{

    /**
     * @param Role $role
     */
    public function saveRole(Role $role);


    /**
     * @param string $name
     *
     * @return Role|null
     */
    public function getRole($name);


    /**
     * Clear the roles.
     */
    public function clearRoles();
}
