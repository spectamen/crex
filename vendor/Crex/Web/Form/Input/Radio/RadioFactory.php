<?php

namespace Crex\Web\Form\Input\Radio;

use Crex\Factory\Factory;

class RadioFactory extends Factory {
    
    public function create($name) {
        return new Radio($this->container, array('name' => $name));
    }
    
}
