<?php

namespace Crisu83\Overseer\Runtime;

use Crisu83\Overseer\Entity\Assignment;
use Crisu83\Overseer\Entity\Subject;
use Crisu83\Overseer\Exception\AssignmentNotFound;

class AssignmentStorage implements \Crisu83\Overseer\Storage\AssignmentStorage
{

    /**
     * @var Assignment[]
     */
    private $assignments;


    /**
     * AssignmentStorage constructor.
     */
    public function __construct()
    {
        $this->assignments = [];
    }


    /**
     * @inheritdoc
     */
    public function saveAssignment(Assignment $assignment)
    {
        $this->assignments[$assignment->getSubjectId()] = $assignment;
    }


    /**
     * @inheritdoc
     */
    public function getAssignment($subjectId)
    {
        return isset($this->assignments[$subjectId]) ? $this->assignments[$subjectId] : null;
    }

    /**
     * @inheritdoc
     */
    public function clearAssignments()
    {
        $this->assignments = [];
    }
}
