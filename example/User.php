<?php

use Crisu83\Overseer\Entity\Subject;

class User implements Subject
{

    /**
     * @var int
     */
    private $id;


    /**
     * User constructor.
     *
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getSubjectId()
    {
        return (string) $this->getId();
    }
}
