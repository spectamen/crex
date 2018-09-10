<?php

namespace Crex\Helper;

abstract class GenHelper {
    
    /*
     * <script src="https://gist.github.com/wayphorier/62880fb05e54bebe34fa9150811ca0c3.js"></script>
     */    
    public static function RandomString($length = 32) {
        $randstr = '';
        srand(intval(microtime(TRUE) * 42)); //DON'T PANIC
        //our array add all letters and numbers if you wish
        $chars = array(
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'p',
            'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '1', '2', '3', '4', '5',
            '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K',
            'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

        for ($rand = 0; $rand <= $length; $rand++) {
            $random = rand(0, count($chars) - 1);
            $randstr .= $chars[$random];
        }
        return $randstr;
    }

}
