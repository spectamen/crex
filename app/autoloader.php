<?php

require_once '..\vendor\Crex\Exception\AutoloaderException.php';

use Crex\Exception\AutoloaderException;

function autoloader($class)
{
    if (mb_strpos($class, '\\') === false && preg_match('/Helper$/', $class)) {
	$class = 'App\\helpers\\' . $class;
    } elseif (mb_strpos($class, 'App\\') !== false) {
	$class = 'a' . ltrim($class, 'A');
    } // Změní App na app
    else {
	$class = 'vendor\\' . $class;
    }
    $path = str_replace('\\', '/', $class) . '.php';
    if (!include('../' . $path)) {
	throw new AutoloaderException('Can not load class ' . $class . '. File ' . $path . ' does not exist.');
    }
}

spl_autoload_register("autoloader");