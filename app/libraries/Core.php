<?php

class Core
{
    protected $currentcontroller = 'Pages'; // Default controller
    protected $currentMethod = 'index'; // Default method
    protected $params = []; // Parameters list

    public function __construct()
    {
        // Get the URL and break it into controller, method, and params
        $url = $this->getURL();

        // Check if the controller exists in the controllers folder
        if (!empty($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            // If it does, set it as the current controller
            $this->currentcontroller = ucwords($url[0]);

            //unset the controller in the URL
            unset($url[0]);
        } else {
            // Default to 'Pages' controller if the specified controller does not exist
            $this->currentcontroller = 'Pages';
        }

        // Require the controller
        require_once '../app/controllers/' . $this->currentcontroller . '.php';

        // Instantiate the controller class
        $this->currentcontroller = new $this->currentcontroller;

        // Check if a method exists in the controller
        if (!empty($url[1]) && method_exists($this->currentcontroller, $url[1])) {
            $this->currentMethod = $url[1];
            unset($url[1]);
        }

        // Get the remaining URL as parameters
        $this->params = $url ? array_values($url) : [];

        // Call the current controller's method with params
        call_user_func_array([$this->currentcontroller, $this->currentMethod], $this->params);
    }

    // Extract the URL
    public function getURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }
}
