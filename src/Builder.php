<?php namespace Crisu83\Overseer;

use Crisu83\Overseer\Entity\Assignment;
use Crisu83\Overseer\Entity\Permission;
use Crisu83\Overseer\Entity\Role;

class Builder
{

    /**
     * @var Overseer
     */
    private $overseer;

    /**
     * @var array
     */
    private $config;


    /**
     * Builder constructor.
     */
    public function __construct(Overseer $overseer, array $config)
    {
        $this->overseer = $overseer;
        $this->config   = $config;
    }


    /**
     *
     */
    public function build()
    {
        if (isset($this->config['roles'])) {
            foreach ($this->config['roles'] as $roleName => $roleConfig) {
                $role = new Role($roleName);

                if (isset($roleConfig['permissions'])) {
                    foreach ($roleConfig['permissions'] as $permissionName) {
                        $role->addPermission($permissionName);
                    }
                }

                $this->overseer->saveRole($role);
            }
        }

        if (isset($this->config['permissions'])) {
            foreach ($this->config['permissions'] as $permissionName => $permissionConfig) {
                $permission = new Permission($permissionName);

                if (isset($permissionConfig['rules'])) {
                    foreach ($permissionConfig['rules'] as $ruleClass) {
                        $permission->addRule(new $ruleClass);
                    }
                }

                $this->overseer->savePermission($permission);
            }
        }

        if (isset($this->config['assignments'])) {
            foreach ($this->config['assignments'] as $subjectId => $assignedRoles) {
                foreach ($assignedRoles as $roleName) {
                    $this->overseer->saveAssignment(new Assignment($roleName, $subjectId));
                }
            }
        }
    }
}
