<?php

class Core
{
    //URL format --> /controller/method/params

    protected $currentcontroller = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->getURL();

        if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            //if controller exists then load it
            $this->currentcontroller = ucwords($url[0]);

            //unset the controller in the url
            unset($url[0]);

            //call the controller
            require_once '../app/controllers/' . $this->currentcontroller . '.php';

            //instantiate current controller
            $this->currentcontroller = new $this->currentcontroller;

            if (isset($url[1])) {
                if (method_exists($this->currentcontroller, $url[1])) {
                    $this->currentMethod = $url[1];

                    unset($url[1]);
                }
            }
            //get parameter list
            $this->params = $url ? array_values($url) : [];

            //call method and pass the parameters
            call_user_func_array([$this->currentcontroller, $this->currentMethod], $this->params);
        }
    }

    public function getURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            return $url;
        }
    }
}
