<?php namespace Crisu83\Overseer\Entity;

use Crisu83\Overseer\Exception\InvalidArgument;

class Permission
{

    const RULE_ALLOW = 1;
    const RULE_DENY = -1;
    const RULE_NEUTRAL = 0;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $resourceName;

    /**
     * @var Rule[]
     */
    private $rules = [];


    /**
     * Permission constructor.
     *
     * @param string      $permissionName
     * @param string|null $resourceName
     */
    public function __construct($permissionName, $resourceName = null)
    {
        $this->setName($permissionName);
        $this->setResourceName($resourceName);
    }


    /**
     * @param Rule $rule
     */
    public function addRule(Rule $rule)
    {
        $this->rules[] = $rule;
    }


    /**
     * @return bool
     */
    public function hasRules()
    {
        return !empty($this->rules);
    }


    /**
     * @param Resource $resource
     *
     * @return bool
     */
    public function appliesToResource(Resource $resource)
    {
        return $this->resourceName === $resource->getResourceName();
    }


    /**
     * @param Subject  $subject
     * @param Resource $resource
     *
     * @return bool
     * @throws InvalidArgument
     */
    public function evaluate(Subject $subject, Resource $resource)
    {
        if (!$this->hasRules()) {
            return true;
        }

        foreach ($this->rules as $rule) {
            if ($rule->evaluate($subject, $resource) === self::RULE_DENY) {
                return false;
            }
        }

        return true;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @param string $name
     */
    private function setName($name)
    {
        if (empty($name)) {
            throw new InvalidArgument('Permission name cannot be empty.');
        }

        $this->name = $name;
    }


    /**
     * @param string $resourceName
     */
    private function setResourceName($resourceName)
    {
        $this->resourceName = $resourceName;
    }
}
