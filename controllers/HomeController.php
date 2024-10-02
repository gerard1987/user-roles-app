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
            'content' => 'Home'
        ];

        $viewData = new ViewData($data);
        
        $this->renderView('index', $viewData);
    }
}