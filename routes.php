<?php

$router->get('/', 'controllers/home.php');
$router->get('/blog', 'controllers/blog/index.php');
$router->get('/blog/create', 'controllers/blog/create.php');
$router->get('/post', 'controllers/blog/show.php');

