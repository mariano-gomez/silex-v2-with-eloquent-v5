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

//These two have to be outside closure
// Make the Capsule instance available globally via static methods...
$capsule->setAsGlobal();
// Setup the Eloquent ORM...
$capsule->bootEloquent();

$app['db'] = $capsule;

