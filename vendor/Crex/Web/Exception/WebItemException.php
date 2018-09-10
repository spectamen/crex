<?php

namespace Crex\Web\Exception;

class WebItemException extends \Exception {
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null, $node = 1) {
        parent::__construct($message, $code, $previous);
        $array = $this->getTrace();
        $this->file = $array[$node]['file'];
        $this->line = $array[$node]['line'];
    }
}
