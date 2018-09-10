<?php

namespace Crex\Web\Form\Input;

use Crex\Factory\Factory;

class InputFactory extends Factory {
    
    public function create($type, $name) {
        $item = new Input($this->container, array('name' => 'input'));
        $item->addAttribute('type', $type);
        $item->addAttribute('name', $name);
        return $item;
    }
    
}
