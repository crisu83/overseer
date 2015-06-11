<?php namespace Crisu83\Overseer\Storage;

use Crisu83\Overseer\Entity\Permission;

interface PermissionStorage
{

    /**
     * @param Permission $permission
     */
    public function savePermission(Permission $permission);


    /**
     * @param $name
     *
     * @return Permission|null
     */
    public function getPermission($name);
}
