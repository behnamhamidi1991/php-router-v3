<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

class BlogController 
{
    protected $db;

    public function __construct () 
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function index() 
    {
        $posts = $this->db->query('SELECT * FROM posts')->fetchAll();

        loadView('blog/index', [
            'posts' => $posts
        ]);
    }

    public function create() 
    {
        loadView('blog/create');
    }

    public function show($params) 
    {
        $id = $params['id'] ?? ''; 

        $params = [
            'id' => $id
        ];

        
        $post = $this->db->query('SELECT * FROM posts WHERE id = :id', $params)->fetch();
    
        loadView('blog/show', [
            'post' => $post
        ]);
    }
}