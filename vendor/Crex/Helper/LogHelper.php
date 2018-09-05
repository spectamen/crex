<?php

namespace crex\Helper;

abstract class LogHelper {
    
    public static function log($message) {
        $string = file_get_contents('log.txt');
        $string = $string . '
' . date('[Y-m-d H-i-s]') . ' => ' . $message;
        
        file_put_contents('log.txt', $string);
    } 
    
}
