<?php
class homeController extends Controller {
    public function index($id = '', $name = ''){
        $AssoParams = helper::createAssoParams(["id","name","pageTitle"],[$id,$name,"Home page"]);
        $this->view("home".DS."index",$AssoParams);
    }
    public function about($id = '', $name = ''){
        $AssoParams = helper::createAssoParams(["id","name","pageTitle"],[$id,$name,"About Us"]);
        $this->view("home".DS."about",$AssoParams);
    }
    public function signup(){
        
    }
    public function login(){
        
    }
    public function search(){
        
    }
}
