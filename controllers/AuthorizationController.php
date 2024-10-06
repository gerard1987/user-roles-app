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
            'content' => null
        ];

        if (!empty($_POST))
        {
            $data = $this->sanitizePostData($_POST);

            $username = $data['username'] ?? throw new Exception('username is required');
            $password = $data['password'] ?? throw new Exception('password is required');

            $user = User::getUser($data);
            if ($user)
            {
                $data['Auth']['User'] = $user;
                Session::setsession($data);

                Router::redirect('/home/index');
            }
            else 
            {
                $data['content']['message'] = 'Incorrect username and password combination';
            }
        }

        $viewData = new ViewData($data);
        
        $this->renderView('login', $viewData);
    }

    public function logout() 
    {
        Session::destroysession();
        Router::redirect('/authorization/login');
    }

    public function register() 
    {
        $data = [
            'title' => 'Register',
        ];

        if (!empty($_POST))
        {
            $data = $this->sanitizePostData($_POST);

            $succes = User::create($data);
            if ($succes){
                Router::redirect('/home/index');
            }
        }

        $viewData = new ViewData($data);
        
        $this->renderView('register', $viewData);
    }

    public function unauthorized() 
    {
        $data = [
            'title' => 'Register',
        ];

        $viewData = new ViewData($data);
        
        $this->renderView('unauthorized', $viewData);
    }
}