<?php
class homeController extends Controller {
    public function index(){
        $AssoParams = helper::createAssoParams(["pageTitle"],["Home page"]);
        $this->view("home".DS."index",$AssoParams);
    }
}
