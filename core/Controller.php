<?php
    class Controller {
        protected $view;
        protected $model;
        public function view($viewName,$viewData) {
            $this->view = new View($viewName,$viewData);
            $this->view->render();
        }
        public function model() {
            
        }
    }
