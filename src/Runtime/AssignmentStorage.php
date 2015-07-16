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
        $key = $this->createKey($assignment->getSubjectId(), $assignment->getSubjectName());
        $this->assignments[$key] = $assignment;
    }


    /**
     * @inheritdoc
     */
    public function getAssignment(Subject $subject)
    {
        $key = $this->createKey($subject->getSubjectId(), $subject->getSubjectName());
        return isset($this->assignments[$key]) ? $this->assignments[$key] : null;
    }

    /**
     * @inheritdoc
     */
    public function clearAssignments()
    {
        $this->assignments = [];
    }


    /**
     * @param $subjectId
     * @param $subjectName
     * @return string
     */
    private function createKey($subjectId, $subjectName)
    {
        return $subjectId . '|' . $subjectName;
    }
}
