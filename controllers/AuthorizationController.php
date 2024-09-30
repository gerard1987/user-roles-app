<?php 

class AuthorizationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index() 
    {
        $data = [
            'title' => 'Login',
            'content' => 'Login'
        ];

        $viewData = new ViewData($data);
        
        $this->renderView('index', $viewData);
    }
}