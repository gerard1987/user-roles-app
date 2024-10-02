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

        if (!empty($_POST))
        {
            $data = $this->sanitizePostData($_POST);

            $username = $data['username'] ?? throw new Exception('username is required');
            $password = $data['password'] ?? throw new Exception('password is required');

            $user = User::getUser($data);
            if ($user){
                $data = [
                    'User' => $user
                ];
                $this->setsession($data);

                $this->redirect('/home/index');
            }
            else {
                $this->redirect('/home/index');
            }
        }

        $viewData = new ViewData($data);
        
        $this->renderView('login', $viewData);
    }

    public function logout() 
    {
        $this->destroysession();
        $this->redirect('/authorization/login');
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
                $this->redirect('/home/index');
            }
        }

        $viewData = new ViewData($data);
        
        $this->renderView('register', $viewData);
    }
}