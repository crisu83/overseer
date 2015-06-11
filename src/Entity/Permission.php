<?php namespace Crisu83\Overseer\Entity;

use Crisu83\Overseer\Exception\InvalidArgument;

class Permission
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var Rule[]
     */
    private $rules = [];


    /**
     * Permission constructor.
     *
     * @param string $resourceName
     * @param string $permissionName
     */
    public function __construct($permissionName)
    {
        $this->setName($permissionName);
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
     * @param Subject  $subject
     * @param Resource $resource
     *
     * @return bool
     * @throws InvalidArgument
     */
    public function evaluate(Subject $subject, Resource $resource)
    {
        if (!$this->hasRules()) {
            return false;
        }

        foreach ($this->rules as $rule) {
            if (!$rule->evaluate($subject, $resource)) {
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
}
