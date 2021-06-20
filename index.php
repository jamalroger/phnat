<?php
require_once __DIR__ . '/vendor/autoload.php';

require_once  __DIR__ . '/app/kernel.php';
define('root', __DIR__);
define('app_root', __DIR__ . '/app');
$kernel = new App\Kernel();

$kernel->execute();
