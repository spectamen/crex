<?php

namespace Crex\Web\Form\Exception;

class FormException extends \Exception {
    
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
        $array = $this->getTrace();
        $this->file = $array[0]['file'];
        $this->line = $array[0]['line'];
    }
    
}
