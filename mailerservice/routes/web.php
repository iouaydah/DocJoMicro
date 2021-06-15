<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('foo', function () {
    return 'Hello World';
});

$router->get('/preview', function () {
    $data = [
        'from' => 'preview@preview.com',
        'subject' => 'Preview Test',
        'message' => 'This is a message preview',
    ];
    return new App\Mail\TestEmail($data);
});
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('Emails',  ['uses' => 'EmailsController@showAllEmails']);
    $router->get('Emails/{id}', ['uses' => 'EmailsController@showOneEmail']);
    $router->post('Emails', ['uses' => 'EmailsController@create']);
    $router->delete('Emails/{id}', ['uses' => 'EmailsController@delete']);
    $router->put('Emails/{id}', ['uses' => 'EmailsController@update']);
  });