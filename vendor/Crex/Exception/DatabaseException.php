<?php

namespace crex\Exception;

class DatabaseException extends \PDOException {
    
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
        $array = $this->getTrace();
        $this->file = $array[0]['file'];
        $this->line = $array[0]['line'];
    }
    
}
