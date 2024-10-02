<?php

    require_once 'models/User.php';
    require_once 'models/ViewData.php';
    require_once 'controllers/Controller.php';
    require_once 'controllers/AuthorizationController.php';
    require_once 'routing/router.php';
    require_once 'data/DataProvider.php';

    $dbProvider = DataProvider::getInstance();

    define('DS', DIRECTORY_SEPARATOR);

    $router = new Router($_SERVER['REQUEST_URI']);
    $router->route();

?>