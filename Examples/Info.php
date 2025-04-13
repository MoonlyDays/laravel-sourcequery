<?php

use MoonlyDays\LaravelSourceQuery\QueryFactory;

require_once '../vendor/autoload.php';

$service = new QueryFactory;
$info = $service->query('146.59.52.20', 27015)->info();
var_dump($info);
