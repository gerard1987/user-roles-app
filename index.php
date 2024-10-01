<?php

    require_once 'models/User.php';
    require_once 'models/ViewData.php';
    require_once 'controllers/Controller.php';
    require_once 'controllers/AuthorizationController.php';
    require_once 'routing/router.php';

    define('DS', DIRECTORY_SEPARATOR);

    $router = new Router();
    $router->route($_SERVER['REQUEST_URI']);

?>