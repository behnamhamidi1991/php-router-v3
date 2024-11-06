<?php

$router->get('/', 'HomeController@index');
$router->get('/blog', 'BlogController@index');
$router->get('/blog/create', 'BlogController@create');
$router->get('/blog/edit/{id}', 'BlogController@edit');
$router->get('/blog/{id}', 'BlogController@show');

$router->post('/blog', 'BlogController@store');
$router->delete('/blog/{id}', 'BlogController@destroy');
$router->put('/blog/{id}', 'BlogController@update');

$router->get('/auth/register', 'UserController@create');
$router->get('/auth/login', 'UserController@login');

$router->post('/auth/register', 'UserController@store');
$router->post('/auth/logout', 'UserController@logout');
$router->post('/auth/login', 'UserController@authenticate');