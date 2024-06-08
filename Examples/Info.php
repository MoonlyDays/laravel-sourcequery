<?php

use MoonlyDays\LaravelSourceQuery\Service;

require_once "../vendor/autoload.php";

$service = new Service();
$info = $service->query('62.122.215.61', 28424)->players();
print_r($info);