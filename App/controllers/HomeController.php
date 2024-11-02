<?php

namespace App\Controllers;

use Framework\Database;

class HomeController {
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function index() {

        $posts = $this->db->query('SELECT * FROM posts ORDER BY created_at DESC LIMIT 6')->fetchAll();

        loadView('home', [
            'posts' => $posts
        ]);
    }


}