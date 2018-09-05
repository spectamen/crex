<?php

namespace crex;

use crex\Container\Container;
use crex\Exception\MemberAccessException;
use crex\Helper\ArrayHelper;
use ReflectionObject;
use ReflectionProperty;

class CrexObject {

    protected $container;

    public function __construct(Container $container, array $parameters = NULL) {
        $this->container = $container;
        if (isset($parameters)) {
            foreach ($parameters as $key => $value) {
                $this->__set($key, $value);
            }
        }
        return $this;
    }

    public function __get($name) {
        $methodName = 'get' . ucfirst($name);
        if (method_exists($this, $methodName)) {
            return $this->$methodName();
        } else {
            return $this->propertyGetter($name);
        }
    }

    public function __set($name, $value) {
        $methodName = 'set' . ucfirst($name);
        if (method_exists($this, $methodName)) {
            return $this->$methodName($value);
        } else {
            return $this->propertySetter($name, $value);
        }
    }

    protected function getService($service) {
        return $this->container->getService($service);
    }

    protected function getNearestProperty($name) {
        $properties = array_keys(get_class_vars(get_class($this)));
        return ArrayHelper::getNearest($properties, $name);
    }

    protected function isPublicProperty($name) {
        $reflection = new ReflectionObject($this);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
        if (array_key_exists($name, $properties)) {
            return true;
        }
        return false;
    }

    protected function propertySetter($name, $value) {
        if (array_key_exists($name, get_class_vars(get_class($this)))) {
            if ($this->isPublicProperty($name)) {
                $this->$name = $value;
                return $this;
            }
            throw new MemberAccessException("Tryied to set protected or private property " . $name . " of class " . get_class($this) . " without defined setter.");
        }
        throw new MemberAccessException("Tryied to set undefined property " . $name . " of class " . get_class($this) . "."
        . " Did you mean " . $this->getNearestProperty($name) . "?");
    }

    protected function propertyGetter($name) {
        if (array_key_exists($name, get_class_vars(get_class($this)))) {
            if ($this->isPublicProperty($name)) {
                return $this->$name;
            }
            throw new MemberAccessException("Tryied to get protected or private property " . $name . " of class " . get_class($this) . " without defined getter.");
        }
        throw new MemberAccessException("Tryied to get undefined property " . $name . " of class " . get_class($this) . "."
        . " Did you mean " . $this->getNearestProperty($name) . "?");
    }

}
