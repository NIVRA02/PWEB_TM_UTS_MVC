<?php


require_once '../app/config.php';
require_once '../app/helpers.php';


$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'pages/index';
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);


$controllerName = ucwords($url[0]) . '.php';
if (file_exists('../app/controllers/' . $controllerName)) {
    require_once '../app/controllers/' . $controllerName;
    $controller = new $url[0];


    $methodName = isset($url[1]) ? $url[1] : 'index';
    if (method_exists($controller, $methodName)) {
        unset($url[0]);
        unset($url[1]);
        $params = $url ? array_values($url) : [];
        call_user_func_array([$controller, $methodName], $params);
    } else {
        die('Method not found.');
    }
} else {

    require_once '../app/controllers/Pages.php';
    $pages = new Pages();
    $pages->index();
}