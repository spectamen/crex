<?php

namespace Crex\Web\Form\Input\Checkbox;

use Crex\Factory\Factory;

class CheckboxFactory extends Factory {
    
    public function create($name) {
        return new Checkbox($this->container, array('name' => $name));
    }
    
}
