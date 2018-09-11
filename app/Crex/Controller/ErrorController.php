<?php

namespace App\Crex\Controller;

use \Crex\Controller\Controller;

class ErrorController extends Controller {
    
    public function life() {
        print_r($this->container->getParsedURL());
    }
    
}
