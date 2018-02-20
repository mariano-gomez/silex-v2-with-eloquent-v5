<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

require __DIR__ . '/../bootstrap/config.php';
require __DIR__ . '/../bootstrap/routes.php';

$app->run();