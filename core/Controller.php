<?php
    class Controller {
        protected $view;
        protected $model;
        public function view($viewName,$viewData) {
            $this->view = new View($viewName,$viewData);
            $this->view->render();
        }
        public function model($modelName) {
            if (file_exists(MODEL . DS . $modelName . ".php")) {
                $this->model = new $modelName;
            }            
        }
    }
