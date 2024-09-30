<?php

    require_once 'models/User.php';
    require_once 'models/ViewData.php';
    require_once 'controllers/Controller.php';
    require_once 'controllers/AuthorizationController.php';

    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $urlSegments = explode('/', trim($url, '/'));
    $controllerSegment = !empty($urlSegments[0]) ? $urlSegments[0] : 'home';
    $action = !empty($urlSegments[1]) ? $urlSegments[1] : 'index';
    $param = !empty($urlSegments[2]) ? $urlSegments[2] : null;

    switch ($controllerSegment) 
    {
        case 'home':
            $controller = new AuthorizationController();
            navigate($controller, $action, $param);
            break;
        case 'articles':
            $controller = new ArticleController();
            navigate($controller, $action, $param);
            break;
        case 'edit':
            $controller = new ArticleController();
            navigate($controller, $action, $param);
            break;
        case 'delete':
            $controller = new ArticleController();
            navigate($controller, $action, $param);
            break;
        default:
            header('HTTP/1.0 404 Not Found');
            echo 'Pagina niet gevonden';
            break;
    }

    function navigate($controller, $action, $param)
    {
        if (method_exists($controller,$action)){
            $controller->{$action}($param);
        }

        header('HTTP/1.0 404 Not Found');
        echo 'Pagina niet gevonden';
        die;
    }
?>