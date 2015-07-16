<?php namespace Crisu83\Overseer\Entity;

use Crisu83\Overseer\Exception\PropertyNotValid;

class Assignment
{

    /**
     * @var string
     */
    private $subjectId;

    /**
     * @var string
     */
    private $subjectName;

    /**
     * @var array
     */
    private $roles;


    /**
     * Assignment constructor.
     *
     * @param string $subjectId
     * @param string $subjectName
     * @param array  $roles
     *
     * @throws PropertyNotValid
     */
    public function __construct($subjectId, $subjectName, array $roles = [])
    {
        $this->setSubjectId($subjectId);
        $this->setSubjectName($subjectName);
        $this->setRoles($roles);
    }


    /**
     * @param string $roleName
     *
     * @throws PropertyNotValid
     */
    public function addRole($roleName)
    {
        if (empty($permissionName)) {
            throw new PropertyNotValid('Role name cannot be empty.');
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
     * @return string
     */
    public function getSubjectName()
    {
        return $this->subjectName;
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
     * @throws PropertyNotValid
     */
    private function setSubjectId($subjectId)
    {
        if (empty($subjectId)) {
            throw new PropertyNotValid('Assignment subject ID cannot be empty.');
        }

        $this->subjectId = $subjectId;
    }


    /**
     * @param string $subjectName
     *
     * @throws PropertyNotValid
     */
    private function setSubjectName($subjectName)
    {
        if (empty($subjectName)) {
            throw new PropertyNotValid('Assignment subject name cannot be empty.');
        }

        $this->subjectName = $subjectName;
    }


    /**
     * @param array $roles
     */
    private function setRoles($roles)
    {
        $this->roles = $roles;
    }
}
