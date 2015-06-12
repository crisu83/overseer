<?php namespace Crisu83\Overseer\Entity;

interface Rule
{

    /**
     * @param Subject  $subject
     * @param Resource $resource
     * @param array    $params
     *
     * @return bool
     */
    public function evaluate(Subject $subject, Resource $resource, array $params);
}
