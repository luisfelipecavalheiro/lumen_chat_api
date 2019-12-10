<?php

use Illuminate\Support\Str;

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
/** Rota Lista todos Clientes - Metodo GET*/
$router->get('/clients', 'ClientController@index');
/** Rota Cadastra Cliente - Metodo Post */
$router->post('/clients', 'ClientController@store');
/** Rota Valida Cadastro Cliente - Metodo Post */
$router->post('/clients/validated', 'ClientController@validated');