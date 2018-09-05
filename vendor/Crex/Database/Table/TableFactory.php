<?php

namespace crex\Database\Table;

use crex\Factory\Factory;
use crex\Database\Table\Table;

class TableFactory extends Factory {
    
    public function create(array $parameters = array()) {
        return new Table($this->container, $parameters);
    }
    
}
