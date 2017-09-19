<?php

use Crisu83\Overseer\Entity\Assignment;
use Crisu83\Overseer\Runtime\AssignmentStorage;

class AssignmentStorageTest extends \Codeception\TestCase\Test
{
    /** @var  $assignmentStorage AssignmentStorage */
    protected $assignmentStorage;

    /**
     * @inheritdoc
     */
    public function _before()
    {
        parent::_before();

        $this->assignmentStorage = new AssignmentStorage();
    }

    /**
     * Tests save assignment
     */
    public function testSaveAssignment()
    {
        $sourceAssignment = new Assignment('1', 'user');

        $this->assignmentStorage->saveAssignment($sourceAssignment);

        $assignment = $this->assignmentStorage->getAssignment('1', 'user');

        $this->assertEquals($sourceAssignment, $assignment);
    }
}
