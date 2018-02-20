<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Security\EloquentUserProvider;

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

//  According to docs, this service is needed if we want to use form authentication
//  So, if we're going to use another kind of authentication (tokens, HTTP authentication), we could remove this
$app->register(new Silex\Provider\SessionServiceProvider());


$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'admin' => array(
//            'anonymous' => true,    //  So we can 'receive' an user when accessing restricted url's, but aren't really needed to be secured
            'pattern' => '^/admin',

//            'security' => $app['debug'] ? false : true,   //  To toggle on/off this firewall configuration

            //  The login_path path must always be defined outside the secured area
            //  The check_path path must always be defined inside the secured area.
            'form' => array(
                'login_path' => '/login',
                'check_path' => '/admin/login_check'
            ),
            'logout' => array(
                'logout_path' => '/admin/logout',   #   Must start with the same pattern than the firewall config pattern
                'invalidate_session' => true
            ),
            'users' => function () use ($app) {
                return new EloquentUserProvider($app['db']);
            }
//            'users' => array(
//                // raw password is foo
//                'admin' => array('ROLE_ADMIN', '$2y$10$3i9/lVd8UOFIJ6PAMFt8gu3/r5g0qeCJvoSlLCsvMTythye19F77a'),
//            ),
        ),
    )
));
