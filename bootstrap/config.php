<?php

use Illuminate\Database\Capsule\Manager as Capsule;

//Set up Fluent Query Builder..
$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => '127.0.0.1',
    'database'  => 'silex',
    'username'  => 'homestead',
    'password'  => 'secret',
    'charset'   => 'utf8',
    'collation' => 'utf8_general_ci',
]);
return $capsule;

$app['db'] = $capsule;

//These two have to be outside closure
// Make the Capsule instance available globally via static methods...
$app['db']->setAsGlobal();
// Setup the Eloquent ORM...
$app['db']->bootEloquent();

/*
$capsule = new Capsule();

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => '127.0.0.1',
    'database'  => 'silex',
    'username'  => 'homestead',
    'password'  => 'secret',
    'charset'   => 'utf8',
    'collation' => 'utf8_general_ci',
]);

$capsule->bootEloquent();*/