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
            'content' => null
        ];

        try 
        {
            if (!empty($_POST))
            {
                $data = $this->sanitizePostData($_POST);
    
                if(empty($data['username'])){ throw new InvalidArgumentException('username is required');}
                if(empty($data['password'])){ throw new InvalidArgumentException('password is required');}
    
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
        }
        catch(InvalidArgumentException $ex)
        {
            $data['content']['message'] = $ex->getMessage();
        }
        catch (Exception $ex)
        {
            $data['content']['message'] = 'Internal server error';
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
            'content' => null
        ];
        
        try 
        {
            if (!empty($_POST))
            {
                $data = $this->sanitizePostData($_POST);

                if(empty($data['username'])){ throw new InvalidArgumentException('username is required');}
                if(empty($data['password'])){ throw new InvalidArgumentException('password is required');}
    
                $succes = User::create($data);
                if ($succes){
                    Router::redirect('/home/index');
                }
                else 
                {
                    $data['content']['message'] = 'Could not create a user, please try again';
                }
            }
        }
        catch (Exception $ex)
        {
            $data['content']['message'] = 'Internal server error';
        }

        $viewData = new ViewData($data);  
        $this->renderView('register', $viewData);   
    }

    public function unauthorized() 
    {
        $data = [
            'title' => 'unauthorized',
        ];

        $viewData = new ViewData($data);
        
        $this->renderView('unauthorized', $viewData);
    }
}