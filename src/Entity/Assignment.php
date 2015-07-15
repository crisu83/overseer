<?php namespace Crisu83\Overseer\Entity;

use Crisu83\Overseer\Exception\InvalidArgument;

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
     * @param Subject $subject
     * @param array $roles
     *
     * @throws InvalidArgument
     */
    public function __construct(Subject $subject, array $roles = [])
    {
        $this->setSubjectId($subject->getSubjectId());
        $this->setSubjectName($subject->getSubjectName());
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
     * @param string $subjectName
     *
     * @throws InvalidArgument
     */
    private function setSubjectName($subjectName)
    {
        if (empty($subjectName)) {
            throw new InvalidArgument('Assignment subject name cannot be empty.');
        }

        $this->subjectName = (string) $subjectName;
    }


    /**
     * @param array $roles
     */
    private function setRoles($roles)
    {
        $this->roles = $roles;
    }
}
