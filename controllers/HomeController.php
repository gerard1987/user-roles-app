<?php 

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    #[AuthorizedAttribute(['user', 'admin'])]
    public function index() 
    {
        $data = [
            'title' => 'Home',
            'content' => 'Home',
            'userData' => $userData = Session::getsession('Auth')['User'] ?? null
        ];

        $viewData = new ViewData($data);
        
        $this->renderView('index', $viewData);
    }

    #[AuthorizedAttribute(['admin'])]
    public function users() 
    {
        $allUsers = User::all();

        $data = [
            'title' => 'Users',
            'content' => $allUsers,
            'userData' => $userData = Session::getsession('Auth')['User'] ?? null
        ];

        $viewData = new ViewData($data);
        
        $this->renderView('users', $viewData);
    }    
    
    #[AuthorizedAttribute(['admin'])]
    public function create_user() 
    {
        if (!empty($_POST))
        {
            $data = $this->sanitizePostData($_POST);

            $succes = User::create($data);
            if ($succes){
                Router::redirect('/home/index');
            }
        }
    }
    
    #[AuthorizedAttribute(['user', 'admin'])]
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
                Router::redirect('/home/index');
            }
        }

        $viewData = new ViewData($data);
        
        $this->renderView('register', $viewData);
    }

}