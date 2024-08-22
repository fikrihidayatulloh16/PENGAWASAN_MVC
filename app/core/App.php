<?php

class App{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();

        if (is_array($url)) {
            // controll
            if (isset($url[0]) && file_exists('../app/controllers/' . $url[0] . '.php')) {
                $this->controller = $url[0];
                unset($url[0]);
            }

            require_once '../app/controllers/' . $this->controller . '.php';
            $this->controller = new $this->controller;

            // method
            if (isset($url[1])) {
                if (method_exists($this->controller, $url[1])) {
                    $this->method = $url[1];
                    unset($url[1]);
                }
            }

            // param
            if (!empty($url)) {
                $this->params = array_values($url);
            }

            // jalankan controller, method, dan param jika ada
            call_user_func_array([$this->controller, $this->method], $this->params);
        } else {
            // Handle the case where $url is not an array or is null
            // For example, you might want to redirect to a 404 page or default controller
            echo 'Invalid URL format';
            // You can also set default values for controller, method, and params if needed
        }
    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        } else {
            return []; // Return an empty array if 'url' is not set
        }
    }
}