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
    private $rules;


    /**
     * Permission constructor.
     *
     * @param string      $permissionName
     * @param string|null $resourceName
     * @param Rule[]      $rules
     */
    public function __construct($permissionName, $resourceName = null, array $rules = [])
    {
        $this->setName($permissionName);
        $this->setResourceName($resourceName);
        $this->setRules($rules);
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
     * @param array    $params
     *
     * @return bool
     */
    public function evaluate(Subject $subject, Resource $resource, array $params)
    {
        if (!$this->hasRules()) {
            return true;
        }

        foreach ($this->rules as $rule) {
            if (!$rule->evaluate($subject, $resource, $params)) {
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


    /**
     * @param Rule[] $rules
     */
    private function setRules($rules)
    {
        $this->rules = $rules;
    }
}
