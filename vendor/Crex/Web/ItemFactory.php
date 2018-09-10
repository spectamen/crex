<?php

namespace Crex\Web;

class ItemFactory extends \Crex\Factory\Factory {
    
    public function create($params = NULL) {
        return new Item($this->container, $params);
    }
    
}
