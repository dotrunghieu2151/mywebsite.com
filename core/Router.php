<?php
    class Router {
        protected $controller = DEFAULT_CONTROLLER;
        protected $action = DEFAULT_ACTION;
        protected $params = [];
        public function __construct(){
            $this->prepareURL();
            $this->handleURL();
        }
        public function prepareURL(){
            if (!empty($_SERVER["REQUEST_URI"])) {
                $url = trim($_SERVER["REQUEST_URI"], '/');
                $url = explode('/',$url);
                $this->controller = (isset($url[1]) && $url[1] != '') ? $url[1] . "Controller" : DEFAULT_CONTROLLER;
                $this->action = isset($url[2]) ? $url[2] : DEFAULT_ACTION;
                unset($url[0], $url[1], $url[2]);
                $this->params = !empty($url) ? array_values($url) : []; 
            }
        }
        public function handleURL(){
            if ( (file_exists(CONTROLLER . $this->controller . ".php")) 
               &&(method_exists($this->controller, $this->action)) ) {
                $this->controller = new $this->controller;
                call_user_func_array([$this->controller, $this->action], $this->params);
            }
            else {
               new errorHandler(404);
            }
        }
    }
