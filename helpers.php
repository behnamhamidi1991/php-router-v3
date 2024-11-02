<?php


/**
 * Get the base route
 * 
 * @param string $path
 * @return string
 */
function basePath ($path = '') 
{
    return __DIR__ . '/' . $path;
}


/**
 * Load a view
 * 
 * @param string $name
 * @return void
 */
function loadView($name, $data = [])
{
    $viewPath = basePath("App/views/{$name}.view.php");

    if (file_exists($viewPath)) {
        extract($data);
        require $viewPath;
    } else {
        echo "Path {$name} does not exist!";
    }
}

/**
 * Load a partial
 * 
 * @param string $name
 * @return void
 */
function loadPartial($name) {
    $partialPath = basePath("App/views/partials/{$name}.php");

    if (file_exists($partialPath)) {
        require $partialPath;
    } else {
        echo "Partial {$name} does not exist!";
    }
}

/**
 * Inspect (a) value(s)
 * 
 * @param mixed $value
 * @return void
 */
function inspect($value) 
{
    echo "<br>";
    var_dump($value);
    echo "</br>";
}

/**
 * Inspect (a) value(s) and die
 * 
 * @param mixed $value
 * @return void
 */
function inspectAndDie($value) 
{
    echo "<br>";
    die(var_dump($value));
    echo "</br>";
}

/**
 * Sanitize Data
 * 
 * @param string $dirty
 * @return string
 */
function sanitize($dirty) 
{
    return filter_var(trim($dirty), FILTER_SANITIZE_SPECIAL_CHARS);
}

/**
 * Redirect route
 * 
 * @param $path
 * @return void
 */
function redirect($path) {
    header("Location: $path");
    exit;
}