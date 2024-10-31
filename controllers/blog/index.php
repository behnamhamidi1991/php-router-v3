<?php


$config = require basePath('config/db.php');
$db = new Database($config);

$posts = $db->query('SELECT * FROM posts LIMIT 6')->fetchAll();




loadView('blog/index', [
    'posts' => $posts
]);