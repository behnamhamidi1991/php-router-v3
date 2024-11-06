<?php

$router->get('/', 'HomeController@index');
$router->get('/blog', 'BlogController@index');
$router->get('/blog/create', 'BlogController@create', ['auth']);
$router->get('/blog/edit/{id}', 'BlogController@edit', ['auth']);
$router->get('/blog/{id}', 'BlogController@show');

$router->post('/blog', 'BlogController@store', ['auth']);
$router->delete('/blog/{id}', 'BlogController@destroy', ['auth']);
$router->put('/blog/{id}', 'BlogController@update', ['auth']);

$router->get('/auth/register', 'UserController@create', ['guest']);
$router->get('/auth/login', 'UserController@login', ['guest']);

$router->post('/auth/register', 'UserController@store', ['guest']);
$router->post('/auth/logout', 'UserController@logout', ['auth']);
$router->post('/auth/login', 'UserController@authenticate', ['guest']);