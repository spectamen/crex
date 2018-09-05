<?php

namespace crex\Database\Table\Column;

use crex\Factory\Factory;
use crex\Database\Table\Column\Column;

class ColumnFactory extends Factory {
    
    public function create(array $parameters = array()) {
        return new Column($this->container, $parameters);
    }
    
}
