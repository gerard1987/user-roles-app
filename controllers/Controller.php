<?php 

class Controller
{
    protected $root;
    private $viewsFolder = 'views';
    private $layoutsFolder = 'layout';
    private $pagesFolder = 'pages';

    public function __construct()
    {
        $this->root = dirname(__DIR__);
    }

    private function renderHeader()
    {
        require_once($this->root . DIRECTORY_SEPARATOR . $this->viewsFolder . DIRECTORY_SEPARATOR . $this->layoutsFolder . DIRECTORY_SEPARATOR . 'header.php');   
    }

    protected function renderView($view, ViewData $viewData)
    {
        $controllerFolder = strtolower(str_replace('Controller', '', get_class($this)));
        $fullPath = $this->root . DIRECTORY_SEPARATOR . $this->viewsFolder . DIRECTORY_SEPARATOR . $this->pagesFolder  . DIRECTORY_SEPARATOR . $controllerFolder . DIRECTORY_SEPARATOR . $view . '.php';

        if (file_exists($fullPath)) 
        {
            $this->renderHeader();

            $viewData->render($fullPath);
        }
        else 
        {
            echo "View $view file not found: ";
            die;
        }
    }

    protected function sanitizePostData($data)
    {
        $sanitizedData = array();

        if (!empty($data)) 
        {
            // Ensure $data is an array
            $data = !is_array($data) ? array($data) : $data;
    
            foreach ($data as $k => $v) 
            {
                if (ctype_digit($v)) 
                {
                    // Cast to integer and sanitize
                    $sanitizedData[$k] = filter_var($v, FILTER_SANITIZE_NUMBER_INT);
                    $sanitizedData[$k] = (int) $sanitizedData[$k];
                }
                elseif (is_numeric($v) && strpos($v, '.') !== false) 
                {
                    // Cast to float and sanitize
                    $sanitizedData[$k] = filter_var($v, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $sanitizedData[$k] = (float) $sanitizedData[$k];
                }
                elseif (is_string($v)) 
                {
                    $sanitizedData[$k] = filter_var($v, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                } 
                elseif (is_array($v)) 
                {
                    // Recursively sanitize array values
                    $sanitizedData[$k] = $this->sanitizePostData($v);
                } 
                else 
                {
                    $sanitizedData[$k] = $v;
                }
            }
        }

    
        return $sanitizedData;
    }

    protected function redirect($url)
    {
        $sanitized_url = filter_var($url, FILTER_SANITIZE_URL);

        header("Location: $sanitized_url");
        exit();    
    }
}