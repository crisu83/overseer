<?php

use Crisu83\Overseer\Entity\Assignment;
use Crisu83\Overseer\Runtime\AssignmentStorage;

class AssignmentStorageTest extends \Codeception\TestCase\Test
{
    /** @var  $assigmentStorage AssignmentStorage */
    protected $assigmentStorage;

    /**
     * @inheritdoc
     */
    public function _before()
    {
        parent::_before();

        $this->assigmentStorage = new AssignmentStorage();
    }

    /**
     * Tests save assignment
     */
    public function testSaveAssignment()
    {
        $sourceAssignment = new Assignment('1', 'user');

        $this->assigmentStorage->saveAssignment($sourceAssignment);

        $assignment = $this->assigmentStorage->getAssignment('1', 'user');

        $this->assertEquals($sourceAssignment, $assignment);
    }
}
