<?php
mb_internal_encoding('UTF-8');
require '..\vendor\Nette\Tracy\tracy.php';
use Tracy\Debugger;
Debugger::enable();

require '..\app\bootload.php';