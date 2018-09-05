<?php

namespace crex\Database;

use crex\Container\Container;
use crex\CrexObject;

abstract class ADatabaseObject extends CrexObject {
    
    protected $connection;
    protected $name;
    
    public function __construct(Container $container, array $parameters = NULL) {
        parent::__construct($container, $parameters);
    }
    
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    
}
