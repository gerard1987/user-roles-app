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
        try 
        {
            $userData = Session::getsession('Auth')['User'] ?? null;
            $data = [
                'title' => 'Home',
                'content' => null,
                'userData' => $userData
            ];
        }
        catch (Exception $ex)
        {
            $data['content']['message'] = 'Internal server error';
        }

        $viewData = new ViewData($data); 
        $this->renderView('index', $viewData);
    }

    #[AuthorizedAttribute(['admin'])]
    public function users() 
    {
        try 
        {
            $allUsers = User::all();
            $userData = Session::getsession('Auth')['User'] ?? null;

            $data = [
                'title' => 'Users',
                'content' => $allUsers,
                'userData' => $userData
            ];
        }
        catch (Exception $ex)
        {
            $data['content']['message'] = 'Internal server error';
        }

        $viewData = new ViewData($data);
        $this->renderView('users', $viewData);
    }    
    
    #[AuthorizedAttribute(['admin'])]
    public function create_user() 
    {
        try 
        {
            if (!empty($_POST))
            {
                $data = $this->sanitizePostData($_POST);
                $succes = User::create($data);

                $data['content']['message'] = $succes ? 'User created' : 'Could not create user';
            }
            else 
            {
                $data['content']['message'] = 'Provide username and password';
            }
        }
        catch (Exception $ex)
        {
            $data['content']['message'] = 'Internal server error';
        }

        $viewData = new ViewData($data);
        $this->renderView('users', $viewData);
    }
    
    #[AuthorizedAttribute(['user', 'admin'])]
    public function reset_password() 
    {
        try 
        {
            $userData = Session::getsession('Auth')['User'] ?? null;
            $data = [
                'title' => 'Reset password',
                'userData' => $userData
            ];
    
            if (!empty($_POST))
            {
                $newPassword = $this->sanitizePostData($_POST)['new_password'] ?? null;
                
                $user = Auth::getLoggedInUser();
                $user->password = $newPassword;
    
                $succes = User::edit($user);

                $data['content']['message'] = $succes ? 'Password reset' : 'Could not reset password';
            }
        }
        catch(Exception $ex)
        {
            $data['content']['message'] = 'Internal server error';
        }

        $viewData = new ViewData($data);
        $this->renderView('index', $viewData);
    }

}