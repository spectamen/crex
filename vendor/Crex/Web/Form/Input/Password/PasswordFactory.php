<?php

namespace Crex\Web\Form\Input\Password;

use Crex\Factory\Factory;

class PasswordFactory extends Factory {
    
    public function create($name) {
        return new Password($this->container, array('name' => $name));
    }
    
}
