<?php

namespace crex\Exception;

class AutoloaderException  extends \LogicException {
    
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
        $array = $this->getTrace();
        $this->file = $array[1]['file'];
        $this->line = $array[1]['line'];
    }
}
