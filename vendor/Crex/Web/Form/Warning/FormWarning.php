<?php

namespace Crex\Web\Form\Warning;

class FormWarning {
    
    static function ThrowWarning($message) {
        $backtrace = debug_backtrace();
        $caller = next($backtrace); 
        trigger_error($message.' in <strong>'.$caller['function'].'</strong> called from <strong>'.$caller['file'].'</strong> on line <strong>'.$caller['line'].'</strong>'."\n<br />error handler", E_USER_WARNING);
    }
    
}
