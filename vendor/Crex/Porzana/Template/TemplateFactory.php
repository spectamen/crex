<?php

namespace Crex\Porzana\Template;

use Crex\Factory\Factory as Factory;

class TemplateFactory extends Factory {
    
    public function create($mainTemplate, $templates = array()) {
        return new Template($this->container, array('mainTemplate' => $mainTemplate, 'templates' => $templates));
    }
    
}
