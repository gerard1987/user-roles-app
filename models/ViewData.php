<?php

class ViewData
{
    private $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function getViewData()
    {
        return $this->data;        
    }

    public function render($filePath)
    {
        extract($this->data);

        if (file_exists($filePath)){
            require_once($filePath);
            die;
        }
    }
}
