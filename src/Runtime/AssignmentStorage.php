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
        $this->assignments[] = $assignment;
    }


    /**
     * @inheritdoc
     */
    public function getAssignments(Subject $subject)
    {
        $id = $subject->getSubjectId();

        $subjectAssignments = [];

        foreach ($this->assignments as $assignment) {
            if ($assignment->getSubjectId() === $id) {
                $subjectAssignments[] = $assignment;
            }
        }

        return $subjectAssignments;
    }
}
