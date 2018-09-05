<?php

namespace Crex\Web\Form\Input\Text;

use Crex\Factory\Factory;

class TextFactory extends Factory {
    
    public function create($name) {
        return new Text($this->container, array('name' => $name));
    }
    
}
