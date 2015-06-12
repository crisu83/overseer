<?php

use Crisu83\Overseer\Entity\Permission;
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
        if (!$resource instanceof Book) {
            return Permission::RULE_NEUTRAL;
        }

        return $resource->getAuthorId() === $subject->getSubjectId() ? Permission::RULE_ALLOW : Permission::RULE_DENY;
    }
}
