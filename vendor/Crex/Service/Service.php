<?php

namespace crex\Service;

use crex\CrexObject;

class Service extends CrexObject  {
    
    public function __construct($container, $parameters = NULL) {
        parent::__construct($container, $parameters);
    }
    
    public function getUID() {
        return spl_object_hash($this);
    }
    
}
