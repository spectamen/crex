<?php

namespace Crex\Web\Form\Input\Hidden;

use Crex\Factory\Factory;

class HiddenFactory extends Factory {
    
    public function create($name) {
        return new Hidden($this->container, array('name' => $name));
    }
    
}
