<?php

    require_once 'models/User.php';
    require_once 'models/ViewData.php';
    require_once 'models/DataProvider.php';
    require_once 'models/Session.php';
    require_once 'models/Auth.php';
    require_once 'models/AuthorizedAttribute.php';
    require_once 'controllers/Controller.php';
    require_once 'controllers/AuthorizationController.php';
    require_once 'routing/router.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    DataProvider::getInstance();

    define('DS', DIRECTORY_SEPARATOR);

    $router = new Router($_SERVER['REQUEST_URI']);
    $router->route();

?>