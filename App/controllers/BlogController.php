<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;

class BlogController 
{
    protected $db;

    public function __construct () 
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    /**
     * Load index view
     *
     * @return void
     */
    public function index() 
    {
        $posts = $this->db->query('SELECT * FROM posts ORDER BY created_at DESC')->fetchAll();

        loadView('blog/index', [
            'posts' => $posts
        ]);
    }

    /**
     * Load create post
     *
     * @return void
     */
    public function create() 
    {
        loadView('blog/create');
    }

    /**
     * Show a single post
     *
     * @param string $params
     * @return void
     */
    public function show($params) 
    {
        $id = $params['id'] ?? ''; 

        $params = [
            'id' => $id
        ];

        
        $post = $this->db->query('SELECT * FROM posts WHERE id = :id ', $params)->fetch();

        
        // Check if the post exists
        if (!$post) {
            ErrorController::notFound('Post not found!');
            return;
        }

    
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

        $newPostData['user_id'] = Session::get('user')['id'];

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

            $_SESSION['success_message'] = 'Post successfully created!';

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
        // Set flash message
        $_SESSION['success_message'] = 'Post successfully deleted!';

        redirect('/blog');
    }

     /**
     * Show the post edit form
     *
     * @param string $params
     * @return void
     */
    public function edit($params) 
    {
        $id = $params['id'] ?? ''; 

        $params = [
            'id' => $id
        ];

        
        $post = $this->db->query('SELECT * FROM posts WHERE id = :id ', $params)->fetch();

        // Check if the post exists
        if (!$post) {
            ErrorController::notFound('Post not found!');
            return;
        }

        loadView('blog/edit', [
            'post' => $post
        ]);
    }


    /**
     * Update a post
     * 
     * @param array $params
     * @return void
     */
    public function update($params) {

        $id = $params['id'] ?? ''; 

        $params = [
            'id' => $id
        ];

        
        $post = $this->db->query('SELECT * FROM posts WHERE id = :id ', $params)->fetch();

        // Check if the post exists
        if (!$post) {
            ErrorController::notFound('Post not found!');
            return;
        }

        $allowedFields = ['title', 'content', 'category'];

        $updatedValues = [];

        $updatedValues = array_intersect_key($_POST, array_flip($allowedFields));

        $updatedValues = array_map('sanitize', $updatedValues);

        $requiredFields = ['title', 'content'];

        $errors = [];

        foreach($requiredFields as $field) {
            if (empty($updatedValues[$field]) || !Validation::string($updatedValues[$field])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }

         // START IMAGE
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
                $updatedValues['image_url'] = '/images/posts/' . $newFileName;
                } else {
                $errors['image_url'] = 'There was an error moving the uploaded file.';
                }
                } else {
                $errors['image_url'] = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
                }
                } else {
                $updatedValues['image_url'] = $post['image_url'];
                }
            // END IMAGE

        if (!empty($errors)) {
            loadView('blog/edit', [
                'post' => $post,
                'errors' => $errors
            ]);
            exit;
        } else {
            // Submit to database
            $updateFields = [];

            foreach(array_keys($updatedValues) as $field) {
                $updatedFields[] = "{$field} = :{$field}";
            }

            $updatedFields = implode(', ', $updatedFields);

            $updatedQuery = "UPDATE posts SET $updatedFields WHERE id = :id";

            $updatedValues['id'] = $id;

           $this->db->query($updatedQuery, $updatedValues);

           $_SESSION['success_message'] = 'Post updated!';
           redirect('/blog/' . $id);
        }
    }

}