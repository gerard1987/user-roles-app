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

    public function __construct($url)
    {
        $this->root = dirname(__DIR__);
        $this->url = parse_url($url, PHP_URL_PATH);
        $this->urlSegments = explode('/', trim($url, '/'));
        $this->controllerSegment = $this->urlSegments[0] ?? null;
        $this->action = $this->urlSegments[1] ?? null;
        $this->param = $this->urlSegments[2] ?? null;
    }

    public function route() 
    {
        $this->navigate($this->controllerSegment, $this->action, $this->param);
    }

    public function navigate($controller, $action, $param)
    {
        $cleanedControllerName = $this->parseControllerName($controller) ?? null;
        $cleanedActionName = $this->parseActionName($action) ?? null;

        if (empty($cleanedControllerName)){
            $this->redirect('home/index');
        }

        $this->loadController($cleanedControllerName);

        if (method_exists($cleanedControllerName,$cleanedActionName))
        {
            if ($this->isAuthorizedForRoute($cleanedControllerName, $cleanedActionName))
            {
                $c = new $cleanedControllerName();
                $c->{$cleanedActionName}($param);
            }
            elseif(!empty(Auth::getLoggedInUser()))
            {
                $this->redirect('authorization/unauthorized', 302);
            }
            else 
            {
                $this->redirect('authorization/login', 302);
            }
        }

        header('HTTP/1.0 404 Not Found');
        echo 'Pagina niet gevonden';
        die;
    }

    private function isAuthorizedForRoute($controller, $view)
    {
        $authorized = false;

        $reflectionClass = new ReflectionClass($controller);
        $attributes = $reflectionClass->getMethod($view)->getAttributes(AuthorizedAttribute::class);

        // Action has attributes, check role
        if (!empty($attributes))
        {
            foreach ($attributes as $attribute) 
            {
                $routeInstance = $attribute->newInstance();
                $user = Auth::getLoggedInUser() ?? null;

                $authorized = empty($user) ? false : ( in_array(strtolower($user->role), $routeInstance->roles) );
            }
        }
        else 
        {
            // No attributes on route, means we let user pass
            $authorized = true;
        }

        return $authorized;
    }

    public function loadController($controller)
    {
        $controllerFile = $this->root . DS . self::CONTROLLERS_FOLDER . DS . $controller . '.php';

        if (file_exists($controllerFile))
        {
            require_once "$controllerFile";
        }
    }

    public function parseControllerName($controllerName): string
    {
        return !empty($controllerName) ? ucfirst(strtolower($controllerName)) . self::CONTROLLER : '';
    }

    public function parseActionName($action): string
    {
        return strtolower($action);
    }

    protected function redirect($url)
    {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
    
        $sanitized_url = $scheme . '://' . $host . '/' . ltrim(filter_var($url, FILTER_SANITIZE_URL), '/');
    
        // Perform the redirect
        header("Location: $sanitized_url");
        exit();    
    }
}