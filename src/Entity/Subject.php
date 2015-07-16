<?php namespace Crisu83\Overseer\Entity;

interface Subject
{

    /**
     * @return string
     */
    public function getSubjectId();

    /**
     * @return string
     */
    public function getSubjectName();
}
