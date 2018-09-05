<?php

namespace Crex\Porzana\Exception;

class TemplateException extends \LogicException {
    
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
        $array = $this->getTrace();
        $this->file = $array[0]['file'];
        $this->line = $array[0]['line'];
    }
    
}
