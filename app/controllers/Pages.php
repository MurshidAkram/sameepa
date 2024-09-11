<?php

class Pages extends controller
{
    public function __construct()
    {
        //echo 'this is the pages controller';
    }

    public function index() {}

    public function about($name, $age)
    {
        $data = [
            'userName' => $name,
            'userAge' => $age
        ];

        $this->view('v_about', $data);
    }
}
