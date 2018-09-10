<?php

namespace Crex\Web\Form\Select;

use Crex\Factory\Factory;

class SelectFactory extends Factory {
    
    public function create($name, $size = 1) {
        $item = new Select($this->container, array('name' => 'select'));
        $item->addAttribute('name', $name)
                ->addAttribute('size', $size);
        return $item;
    }
    
}
