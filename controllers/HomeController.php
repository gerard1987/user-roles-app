<?php 

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index() 
    {
        $data = [
            'title' => 'Home',
            'content' => 'Home',
            'userData' => $userData = Session::getsession('Auth')['User']
        ];

        $viewData = new ViewData($data);
        
        $this->renderView('index', $viewData);
    }
    
    public function create_user() 
    {
        if (!empty($_POST))
        {
            $data = $this->sanitizePostData($_POST);

            $succes = User::create($data);
            if ($succes){
                $this->redirect('/home/index');
            }
        }
    }
    
    public function reset_password() 
    {
        $data = [
            'title' => 'Reset password',
        ];

        if (!empty($_POST))
        {
            $newPassword = $this->sanitizePostData($_POST)['new_password'] ?? null;
            
            $user = Auth::getLoggedInUser();
            $user->password = $newPassword;

            $succes = User::edit($user);
            if ($succes){
                $this->redirect('/home/index');
            }
        }

        $viewData = new ViewData($data);
        
        $this->renderView('register', $viewData);
    }

}