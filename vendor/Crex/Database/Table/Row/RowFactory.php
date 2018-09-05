<?php

namespace crex\Database\Table\Row;

use crex\Factory\Factory;
use crex\Database\Table\Row\Row;

class RowFactory extends Factory {
    
    public function create(array $columns, array $values = NULL) {
        return new Row($this->container, $columns, $values);
    }
    
}
