<?php namespace Crisu83\Overseer;

use Crisu83\Overseer\Entity\Assignment;
use Crisu83\Overseer\Entity\Permission;
use Crisu83\Overseer\Entity\Resource;
use Crisu83\Overseer\Entity\Role;
use Crisu83\Overseer\Entity\Subject;
use Crisu83\Overseer\Exception\PermissionNotFound;
use Crisu83\Overseer\Exception\RoleNotFound;
use Crisu83\Overseer\Storage\AssignmentStorage;
use Crisu83\Overseer\Storage\PermissionStorage;
use Crisu83\Overseer\Storage\RoleStorage;

class Overseer
{

    /**
     * @var RoleStorage
     */
    private $roleStorage;

    /**
     * @var PermissionStorage
     */
    private $permissionStorage;

    /**
     * @var AssignmentStorage
     */
    private $assignmentStorage;


    /**
     * Overseer constructor.
     *
     * @param RoleStorage       $roleStorage
     * @param PermissionStorage $permissionStorage
     * @param AssignmentStorage $assignmentStorage
     */
    public function __construct(
        RoleStorage $roleStorage,
        PermissionStorage $permissionStorage,
        AssignmentStorage $assignmentStorage
    ) {
        $this->roleStorage       = $roleStorage;
        $this->permissionStorage = $permissionStorage;
        $this->assignmentStorage = $assignmentStorage;
    }


    /**
     * @param array $config
     */
    public function configure(array $config)
    {
        $builder = new Builder($this, $config);

        $builder->build();
    }


    /**
     * @param Role $role
     */
    public function saveRole(Role $role)
    {
        $this->roleStorage->saveRole($role);
    }


    /**
     * @param Permission $permission
     */
    public function savePermission(Permission $permission)
    {
        $this->permissionStorage->savePermission($permission);
    }


    /**
     * @param Assignment $assignment
     */
    public function saveAssignment(Assignment $assignment)
    {
        $this->assignmentStorage->saveAssignment($assignment);
    }


    /**
     * @param Subject $subject
     *
     * @return array
     * @throws PermissionNotFound
     * @throws RoleNotFound
     */
    public function getPermissions(Subject $subject)
    {
        $permissions = [];

        foreach ($this->getPermissionsForSubject($subject) as $permission) {
            if (!$permission->hasRules()) {
                $permissions[] = $permission->getName();
            }
        }

        return $permissions;
    }


    /**
     * @param Subject  $subject
     * @param Resource $resource
     *
     * @return array
     * @throws PermissionNotFound
     * @throws RoleNotFound
     */
    public function getPermissionsForResource(Subject $subject, Resource $resource)
    {
        $permissions = [];

        foreach ($this->getPermissionsForSubject($subject) as $permission) {
            if ($permission->evaluate($subject, $resource)) {
                $permissions[] = $permission->getName();
            }
        }

        return $permissions;
    }


    /**
     * @param string        $name
     * @param Subject       $subject
     * @param Resource|null $resource
     *
     * @return bool
     */
    public function hasPermission($name, Subject $subject, Resource $resource = null)
    {
        $permissions = $this->getPermissions($subject);

        if ($resource !== null) {
            $permissions = array_merge($this->getPermissionsForResource($subject, $resource), $permissions);
        }

        return in_array($name, $permissions);
    }


    /**
     * @param Subject $subject
     *
     * @return Permission[]
     * @throws PermissionNotFound
     * @throws RoleNotFound
     */
    protected function getPermissionsForSubject(Subject $subject)
    {
        $permissions = [];

        $assignments = $this->assignmentStorage->getAssignments($subject);

        foreach ($assignments as $assignment) {
            $roleName = $assignment->getRoleName();

            $role = $this->roleStorage->getRole($roleName);

            if ($role === null) {
                throw new RoleNotFound($roleName);
            }

            foreach ($role->getPermissions() as $permissionName) {
                $permission = $this->permissionStorage->getPermission($permissionName);

                if ($permission === null) {
                    throw new PermissionNotFound($permissionName);
                }

                $permissions[] = $permission;
            }
        }

        return $permissions;
    }
}
