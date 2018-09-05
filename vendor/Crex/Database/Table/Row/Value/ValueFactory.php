<?php

namespace crex\Database\Table\Row\Value;

use crex\Factory\Factory;

class ValueFactory extends Factory {
    
    public function create($column, $value) {
        return new Value($this->container, $column, $value);
    }
    
}
