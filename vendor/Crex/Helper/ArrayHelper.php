<?php

namespace crex\Helper;

abstract class ArrayHelper {
    
    public static function getNearest(array $stack, string $needle) {
        $best = '';
        $distance = 999999999999999999999;
        foreach ($stack as $value) {
            if (levenshtein($needle, $value) < $distance) {
                $distance = levenshtein($needle, $value);
                $best = $value;
            }
        }
        return $best;
    }
    
}
