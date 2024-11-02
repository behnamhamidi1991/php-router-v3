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
        $posts = $this->db->query('SELECT * FROM posts ORDER BY created_at DESC')->fetchAll();

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

        
        $post = $this->db->query('SELECT * FROM posts WHERE id = :id ', $params)->fetch();
    
        loadView('blog/show', [
            'post' => $post
        ]);
    }

    /**
     * Store data in database
     * 
     * @return void
     */
    public function store() 
    {
        $allowedFields = ['title', 'content', 'category'];

        $newPostData = array_intersect_key($_POST, array_flip($allowedFields));

        $newPostData['user_id'] = 1;

        $newPostData = array_map('sanitize', $newPostData);

        $requiredFields = ['title', 'content'];

        $errors = [];

        foreach($requiredFields as $field) {
            if(empty($newPostData[$field]) || !Validation::string($newPostData[$field])) {
                $errors[$field] = ucfirst($field) . ' is required!';
            }
        }

        // Handle file upload
        if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image_url']['tmp_name'];
            $fileName = $_FILES['image_url']['name'];
            $fileSize = $_FILES['image_url']['size'];
            $fileType = $_FILES['image_url']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            
            // Sanitize file name
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            // Check if the file has one of the allowed extensions
            $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
            if (in_array($fileExtension, $allowedfileExtensions)) {
            // Directory in which the uploaded file will be moved
            $uploadFileDir = basePath('public/images/posts/');
            $dest_path = $uploadFileDir . $newFileName;

            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                // Store the relative path
                $newPostData['image_url'] = '/images/posts/' . $newFileName;
                } else {
                $errors['image_url'] = 'There was an error moving the uploaded file.';
                }
                } else {
                $errors['image_url'] = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
                }
                } else {
                $errors['image_url'] = 'Image is required!';
                }

        if (!empty($errors)) {
            // Reload view with errors
            loadView('blog/create', [
                'errors' => $errors,
                'post' => $newPostData
            ]);
        } else {
            // Submit data

            $fields = [];

            foreach($newPostData as $field => $value) {
                $fields[] = $field;
            }

            $fields = implode(', ', $fields);

            $values = [];

            foreach($newPostData as $field => $value) {
                // Convert empty strings to null
                if ($value === '') {
                    $newPostData[$field] = null;
                }
                $values[] = ':' . $field;
            }

            $values = implode(', ', $values);

            $query = "INSERT INTO posts ({$fields}) VALUES ({$values})";

            $this->db->query($query, $newPostData);

            redirect('/blog');
        }
    }

    /**
     * Delete a post
     * 
     * @param array $params
     * @return void
     */
    public function destroy ($params) {
        $id = $params['id'];

        $params = [
            'id' => $id
        ];

        $post = $this->db->query('SELECT * FROM posts WHERE id = :id', $params)->fetch();

        if (!$post) {
            ErrorController::notFound('Post not found!');
            return;
        }

        $this->db->query('DELETE FROM posts WHERE id = :id', $params);
        redirect('/blog');
    }
}