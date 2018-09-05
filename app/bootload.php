<?php

use Crex\Site;
use Nette\Neon\Neon;

require '..\vendor\Nette\Neon\Neon.php';
require '..\app\autoloader.php';

$constants = Neon::decode(file_get_contents('..\app\config.neon'));
foreach($constants as $key => $value) {
    define(strtoupper($key), $value);
}

new Site();