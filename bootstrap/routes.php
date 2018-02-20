<?php

use App\Models\User;

$app->get('encode/{rawPassword}', function ($rawPassword) use ($app) {
    //  TODO: Una vez terminado el tema de la autenticacion, buscar el salt por defecto
    echo $app['security.default_encoder']->encodePassword($rawPassword, '');
    return ' Hello ';
});

$app->get('/', function () use ($app) {
    $token = $app['security.token_storage']->getToken();
    if (null !== $token) {
        $user = $token->getUser();
    }
    return ' Hello ';
});

$app->get('/admin', function () use ($app) {
    $token = $app['security.token_storage']->getToken();
    if (null !== $token) {
        $user = $token->getUser();
        dump($user);
    }
    echo $app['security.authorization_checker']->isGranted('ROLE_OWNER');
    return 'secured area';
});

$app->get('/login', function () use ($app) {
    return file_get_contents(__DIR__.'/../app/Templates/login_form.php');
});

$app->get('/models', function () use ($app) {
    dump(User::all());
    return 'bar';
});

$app->get('/hello/{name}', function ($name) use ($app) {
    return 'Hello '.$app->escape($name);
});