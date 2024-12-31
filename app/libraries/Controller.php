<?php

class Controller
{
    /**
     * Load the model
     */
    public function model($model)
    {
        // Define the path to the model file
        $modelPath = '../app/models/' . $model . '.php';
        
        // Check if the model file exists
        if (file_exists($modelPath)) {
            require_once $modelPath;
            
            // Instantiate and return the model
            if (class_exists($model)) {
                return new $model();
            } else {
                die("Model class $model does not exist in $modelPath.");
            }
        } else {
            die("Model file for $model not found at path $modelPath.");
        }
    }

    /**
     * Load the view
     */
    public function view($view, $data = [])
    {
        // Define the path to the view file
        $viewPath = '../app/views/' . $view . '.php';
        
        // Check if the view file exists
        if (file_exists($viewPath)) {
            // Make data variables available in the view
            extract($data);
            require_once $viewPath;
        } else {
            die("View $view does not exist at path $viewPath.");
        }
    }
}

