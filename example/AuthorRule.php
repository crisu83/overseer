<?php

use Crisu83\Overseer\Entity\Resource;
use Crisu83\Overseer\Entity\Rule;
use Crisu83\Overseer\Entity\Subject;

class AuthorRule implements Rule
{

    /**
     * @inheritdoc
     */
    public function evaluate(Subject $subject, Resource $resource)
    {
        if (!$resource instanceof HasAuthor) {
            return false;
        }

        return $resource->getAuthorId() === $subject->getSubjectId();
    }
}
