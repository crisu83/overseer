<?php namespace Crisu83\Overseer\Entity;

use Crisu83\Overseer\Exception\InvalidArgument;

class Assignment
{

    /**
     * @var string
     */
    private $subjectId;

    /**
     * @var array
     */
    private $roles;


    /**
     * Assignment constructor.
     *
     * @param string $subjectId
     * @param array  $roles
     */
    public function __construct($subjectId, array $roles = [])
    {
        $this->setSubjectId($subjectId);
        $this->setRoles($roles);
    }


    /**
     * @param string $roleName
     *
     * @throws InvalidArgument
     */
    public function addRole($roleName)
    {
        if (empty($permissionName)) {
            throw new InvalidArgument('Role name cannot be empty.');
        }

        if ($this->hasRole($roleName)) {
            return;
        }

        $this->roles[] = $roleName;
    }


    /**
     * @return bool
     */
    public function hasRoles()
    {
        return !empty($this->roles);
    }


    /**
     * @return string
     */
    public function getSubjectId()
    {
        return $this->subjectId;
    }


    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
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
     * @param mixed $subjectId
     *
     * @throws InvalidArgument
     */
    private function setSubjectId($subjectId)
    {
        if (empty($subjectId)) {
            throw new InvalidArgument('Assignment subject ID cannot be empty.');
        }

        $this->subjectId = (string) $subjectId;
    }


    /**
     * @param array $roles
     */
    private function setRoles($roles)
    {
        $this->roles = $roles;
    }
}
