<?php namespace Crisu83\Overseer\Entity;

interface Rule
{

    /**
     * @param Subject  $subject
     * @param Resource $resource
     *
     * @return bool
     */
    public function evaluate(Subject $subject, Resource $resource);
}
