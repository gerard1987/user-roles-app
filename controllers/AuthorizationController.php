<?php 

class AuthorizationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login() 
    {
        $data = [
            'title' => 'Login',
            'content' => 'Login'
        ];

        $viewData = new ViewData($data);
        
        $this->renderView('login', $viewData);
    }
}