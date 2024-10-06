<?php 

class Router 
{
    private static $url;
    private static $urlSegments;
    private static $controllerSegment;
    private static $action;
    private static $param;

    private static $root;

    const CONTROLLERS_FOLDER = 'controllers';
    const VIEWS_FOLDER = 'views';
    const MODELS_FOLDER = 'models';
    const CONTROLLER = 'Controller';

    public static function start() 
    {
        self::$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        self::$urlSegments = explode('/', trim(self::$url, '/'));
        self::$controllerSegment = self::$urlSegments[0] ?? null;
        self::$action = self::$urlSegments[1] ?? null;
        self::$param = self::$urlSegments[2] ?? null;

        self::navigate(self::$controllerSegment, self::$action, self::$param);
    }

    private static function navigate($controller, $action, $param)
    {
        $cleanedControllerName = self::parseControllerName($controller) ?? null;
        $cleanedActionName = self::parseActionName($action) ?? null;

        if (empty($cleanedControllerName)){
            self::redirect('home/index');
        }

        self::loadController($cleanedControllerName);

        if (method_exists($cleanedControllerName,$cleanedActionName))
        {
            if (self::isAuthorizedForRoute($cleanedControllerName, $cleanedActionName))
            {
                $c = new $cleanedControllerName();
                $c->{$cleanedActionName}($param);
            }
            elseif(!empty(Auth::getLoggedInUser()))
            {
                self::redirect('authorization/unauthorized', 302);
            }
            else 
            {
                self::redirect('authorization/login', 302);
            }
        }

        header('HTTP/1.0 404 Not Found');
        echo 'Pagina niet gevonden';
        die;
    }

    private static function isAuthorizedForRoute($controller, $view)
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
            // No attributes on action, means its publicly accesible
            $authorized = true;
        }

        return $authorized;
    }

    private static function loadController($controller)
    {
        $controllerFile = BASE . DS . self::CONTROLLERS_FOLDER . DS . $controller . '.php';

        if (file_exists($controllerFile))
        {
            require_once "$controllerFile";
        }
    }

    private static function parseControllerName($controllerName): string
    {
        return !empty($controllerName) ? ucfirst(strtolower($controllerName)) . self::CONTROLLER : '';
    }

    private static function parseActionName($action): string
    {
        return strtolower($action);
    }

    public static function redirect($url)
    {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
    
        $sanitized_url = $scheme . '://' . $host . '/' . ltrim(filter_var($url, FILTER_SANITIZE_URL), '/');
    
        // Perform the redirect
        header("Location: $sanitized_url");
        exit();    
    }
}