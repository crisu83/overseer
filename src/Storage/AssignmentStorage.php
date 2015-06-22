<?php namespace Crisu83\Overseer\Storage;

use Crisu83\Overseer\Entity\Assignment;
use Crisu83\Overseer\Entity\Subject;

interface AssignmentStorage
{

    /**
     * @param Assignment $assignment
     */
    public function saveAssignment(Assignment $assignment);


    /**
     * @param string $subjectId
     *
     * @return Assignment
     */
    public function getAssignment($subjectId);

    /**
     * Clear the assignments.
     */
    public function clearAssignments();
}
