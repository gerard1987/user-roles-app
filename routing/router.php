<?php 

class Router 
{
    private $url;
    private $urlSegments;
    private $controllerSegment;
    private $action;
    private $param;

    private $root;

    const CONTROLLERS_FOLDER = 'controllers';
    const VIEWS_FOLDER = 'views';
    const MODELS_FOLDER = 'models';
    const CONTROLLER = 'Controller';

    public function __construct()
    {
        $this->root = dirname(__DIR__);
    }

    public function parseRequestUri($url)
    {
        $this->url = parse_url($url, PHP_URL_PATH);
        $this->urlSegments = explode('/', trim($url, '/'));
        $this->controllerSegment = $this->urlSegments[0] ?? null;
        $this->action = $this->urlSegments[1] ?? null;
        $this->param = $this->urlSegments[2] ?? null;
    }

    public function route($url) 
    {
        $this->parseRequestUri($url);

        if (!empty($this->controllerSegment))
        {
            $this->navigate($this->controllerSegment, $this->action, $this->param);
        }
        else 
        {
            $this->navigate('AuthorizationController', 'login', null);
        }
    }

    public function loadController($controller)
    {
        $controllerFile = $this->root . DS . self::CONTROLLERS_FOLDER . DS . $controller;
        if (file_exists($controllerFile) && class_exists($controller))
        {
            require_once "$controller.php";
        }
    }

    public function navigate($controller, $action, $param)
    {
        $cleanedControllerName = $this->parseControllerName($this->controllerSegment);
        $cleanedActionName = $this->parseActionName($this->action) ?? null;

        $this->loadController($cleanedControllerName);

        if (method_exists($cleanedControllerName,$cleanedActionName)){
            $c = new $cleanedControllerName();
            $c->{$cleanedActionName}($param);
        }

        header('HTTP/1.0 404 Not Found');
        echo 'Pagina niet gevonden';
        die;
    }

    public function parseControllerName($controllerName): string
    {
        return ucfirst(strtolower($controllerName)) . self::CONTROLLER;
    }

    public function parseActionName($action): string
    {
        return strtolower($action);
    }    
}