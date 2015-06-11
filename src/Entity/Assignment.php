<?php namespace Crisu83\Overseer\Entity;

use Crisu83\Overseer\Exception\InvalidArgument;

class Assignment
{

    /**
     * @var string
     */
    private $roleName;

    /**
     * @var string
     */
    private $subjectId;


    /**
     * Assignment constructor.
     *
     * @param string $roleName
     * @param string $subjectId
     */
    public function __construct($roleName, $subjectId)
    {
        $this->setRoleName($roleName);
        $this->setSubjectId($subjectId);
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
    public function getRoleName()
    {
        return $this->roleName;
    }


    /**
     * @param string $roleName
     */
    private function setRoleName($roleName)
    {
        if (empty($roleName)) {
            throw new InvalidArgument('Assignment role name cannot be empty.');
        }

        $this->roleName = $roleName;
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
}
