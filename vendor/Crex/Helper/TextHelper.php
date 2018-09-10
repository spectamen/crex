<?php

namespace Crex\Helper;

abstract class TextHelper {
    
    public static function isASCII($string) {
        if(preg_match('~[^\x00-\x7F]~', $string)) {
            return FALSE;
        }
        return TRUE;
    }
    
    public static function hasWhitespace($string) {
        if(preg_match('~\s~', $string)) {
            return TRUE;
        }
        return FALSE;
    }
    
}
