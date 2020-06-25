<?php

declare(strict_types=1);

\session_start();

require_once(\dirname(__DIR__) . '/bootstrap.php');

$fc = new PHPCensor\Application($config);
print $fc->handleRequest();
