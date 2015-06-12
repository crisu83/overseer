<?php namespace Crisu83\Overseer\Entity;

interface Rule
{

    /**
     * @param Subject  $subject
     * @param Resource $resource
     *
     * @return int
     */
    public function evaluate(Subject $subject, Resource $resource);
}
