<?php

namespace Crex\Web\Form\Textarea;

use Crex\Factory\Factory;

class TextareaFactory extends Factory {
    
    public function create($name, $rows = 3, $cols = 20) {
        $item = new Textarea($this->container, 'textarea');
        $item->addAttribute('rows', $rows);
        $item->addAttribute('cols', $cols);
        return $item;
    }
    
}
