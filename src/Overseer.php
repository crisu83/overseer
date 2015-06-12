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
     */
    public function getPermissions(Subject $subject, Resource $resource = null)
    {
        $permissions = [];

        foreach ($this->getPermissionsForSubject($subject) as $permissionName => $permission) {
            if ($resource === null && $permission->hasRules()) {
                continue;
            }

            if ($resource !== null && !$this->evaluatePermission($permission, $subject, $resource)) {
                continue;
            }

            $permissions[] = $permissionName;
        }

        return $permissions;
    }


    /**
     * @param Permission $permission
     * @param Subject    $subject
     * @param Resource   $resource
     *
     * @return bool
     */
    protected function evaluatePermission(Permission $permission, Subject $subject, Resource $resource)
    {
        if (!$permission->appliesToResource($resource)) {
            return false;
        }

        if (!$permission->evaluate($subject, $resource)) {
            return false;
        }

        return true;
    }


    /**
     * @param string        $permissionName
     * @param Subject       $subject
     * @param Resource|null $resource
     *
     * @return bool
     */
    public function hasPermission($permissionName, Subject $subject, Resource $resource = null)
    {
        return in_array($permissionName, $this->getPermissions($subject, $resource));
    }


    /**
     * @param Subject $subject
     *
     * @return Assignment|null
     */
    protected function getAssignmentsForSubject(Subject $subject)
    {
        return $this->assignmentStorage->getAssignment($subject->getSubjectId());
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

        $assignment = $this->getAssignmentsForSubject($subject);

        if ($assignment !== null && $assignment->hasRoles()) {
            $roles = array_merge($this->getRolesByNames($assignment->getRoles()), $roles);
        }

        return $roles;
    }


    /**
     * @param Subject $subject
     *
     * @return Permission[]
     * @throws PermissionNotFound
     */
    protected function getPermissionsForSubject(Subject $subject)
    {
        $permissions = [];

        foreach ($this->getRolesForSubject($subject) as $role) {
            if ($role->hasPermissions()) {
                $permissions = array_merge($this->getPermissionsByNames($role->getPermissions()), $permissions);
            }
        }

        return $permissions;
    }


    /**
     * @param array $roleNames
     *
     * @return Role[]
     * @throws RoleNotFound
     */
    protected function getRolesByNames(array $roleNames)
    {
        $roles = [];

        foreach ($roleNames as $roleName) {
            $role = $this->roleStorage->getRole($roleName);

            if ($role === null) {
                throw new RoleNotFound($roleName);
            }

            if ($role->hasRoles()) {
                $roles = array_merge($this->getRolesByNames($role->getRoles()), $roles);
            }

            $roles[$roleName] = $role;
        }

        return $roles;
    }


    /**
     * @param array $permissionNames
     *
     * @return Permission[]
     * @throws PermissionNotFound
     */
    protected function getPermissionsByNames(array $permissionNames)
    {
        $permissions = [];

        foreach ($permissionNames as $permissionName) {
            if (isset($permissions[$permissionName])) {
                continue;
            }

            $permission = $this->permissionStorage->getPermission($permissionName);

            if ($permission === null) {
                throw new PermissionNotFound($permissionName);
            }

            $permissions[$permissionName] = $permission;
        }

        return $permissions;
    }
}
