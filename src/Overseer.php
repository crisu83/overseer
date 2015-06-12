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
     * @param Subject       $subject
     * @param Resource|null $resource
     *
     * @return array
     * @throws PermissionNotFound
     * @throws RoleNotFound
     */
    public function getPermissions(Subject $subject, Resource $resource = null)
    {
        $permissions = [];

        foreach ($this->getPermissionsForSubject($subject) as $permission) {
            if ($permission->hasRules() && $resource === null) {
                continue;
            }

            if ($resource !== null && !$permission->evaluate($subject, $resource)) {
                continue;
            }

            $permissions[] = $permission->getName();
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
        return in_array($name, $this->getPermissions($subject, $resource));
    }


    /**
     * @param Subject $subject
     *
     * @return Assignment[]
     */
    protected function getAssignmentsForSubject(Subject $subject)
    {
        return $this->assignmentStorage->getAssignments($subject);
    }


    /**
     * @param Subject $subject
     *
     * @return Role[]
     * @throws RoleNotFound
     */
    protected function getRolesForSubject(Subject $subject)
    {
        $roles = [];

        foreach ($this->getAssignmentsForSubject($subject) as $assignment) {
            $roleName = $assignment->getRoleName();

            $role = $this->roleStorage->getRole($roleName);

            if ($role === null) {
                throw new RoleNotFound($roleName);
            }

            $roles[] = $role;
        }

        return $roles;
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

        foreach ($this->getRolesForSubject($subject) as $role) {
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
