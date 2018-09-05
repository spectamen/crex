<?php

namespace crex\Factory;

use crex\CrexObject;

abstract class Factory extends CrexObject {
    
    public function __construct($container, $parameters = NULL) {
        parent::__construct($container, $parameters);
    }
    
    public function getUID() {
        return spl_object_hash($this);
    }
    
}
