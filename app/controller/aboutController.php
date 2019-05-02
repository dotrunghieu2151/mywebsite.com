<?php
class aboutController extends Controller {
    public function index($id = '', $name = '') {
        $AssoParams = helper::createAssoParams(["id","name","pageTitle"],[$id,$name,"About Us"]);
        $this->view("about".DS."about",$AssoParams);
    }
}
