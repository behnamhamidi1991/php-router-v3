<?php 

public function update($params) {
$id = $params['id'] ?? ''; 
$params = ['id' => $id];

$post = $this->db->query('SELECT * FROM posts WHERE id = :id ', $params)->fetch();

// Check if the post exists
if (!$post) {
ErrorController::notFound('Post not found!');
return;
}

$allowedFields = ['title', 'content', 'category'];
$newPostData = array_intersect_key($_POST, array_flip($allowedFields));
$newPostData = array_map('sanitize', $newPostData);

$requiredFields = ['title', 'content'];
$errors = [];

foreach($requiredFields as $field) {
if (empty($newPostData[$field]) || !Validation::string($newPostData[$field])) {
$errors[$field] = ucfirst($field) . ' is required!';
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

if (move_uploaded_file($fileTmpPath, $dest_path)) {
// Store the relative path
$newPostData['image_url'] = '/images/posts/' . $newFileName;
} else {
$errors['image_url'] = 'There was an error moving the uploaded file.';
}
} else {
$errors['image_url'] = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
}
} else {
// [**Retain the existing image URL if no new image is uploaded**](https://www.bing.com/search?form=SKPBOT&q=Retain%20the%20existing%20image%20URL%20if%20no%20new%20image%20is%20uploaded)
[**$newPostData['image_url'] = $post['image_url'];**](https://www.bing.com/search?form=SKPBOT&q=%24newPostData%5B%26apos%3Bimage_url%26apos%3B%5D%20%3D%20%24post%5B%26apos%3Bimage_url%26apos%3B%5D%3B)
}
// END IMAGE

if (!empty($errors)) {
loadView('blog/edit', [
'post' => $post,
'errors' => $errors
]);
exit;
} else {
// Prepare fields and values for the SQL query
$fields = [];
foreach ($newPostData as $field => $value) {
$fields[] = $field . ' = :' . $field;
}
$fields = implode(', ', $fields);

$query = "UPDATE posts SET {$fields} WHERE id = :id";
$newPostData['id'] = $id;
$this->db->query($query, $newPostData);
redirect('/blog');
}
}