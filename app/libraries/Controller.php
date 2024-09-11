<?php

class Controller
{
    //load the model
    public function model($model)
    {
        require_once '../app/models/' . $model . '.php';

        //instatnitate the model and pass it to controller variable

        return new $model();
    }


    //load the view
    public function view($view, $data = [])
    {
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            die("Correspomding view does not exist");
        }
    }
}
