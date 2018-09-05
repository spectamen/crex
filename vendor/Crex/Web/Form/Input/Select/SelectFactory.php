<?php

namespace Crex\Web\Form\Input\Select;

use Crex\Factory\Factory;

class SelectFactory extends Factory {
    
    public function create($name) {
        return new Select($this->container, array('name' => $name));
    }
    
}
