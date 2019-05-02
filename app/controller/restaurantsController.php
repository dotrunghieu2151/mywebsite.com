<?php
class restaurantsController extends Controller {
    public function index() {
       $this->show("page1");
    }
    public function show($page){
        if (!preg_match("/^page\d+$/",$page)) {
            header("Location: /mywebsite.com/restaurants");
            exit();
        }
        $page = (int)str_replace("page", "", $page);
        $this->model("Restaurants");
        $this->model->count();
        $totalResults = (int)$this->model->getResult()[0]["COUNT"];
        $totalPages = ceil($totalResults/resultPerPage);       
        if ($page < 1) {
            $page = 1;
        }
        elseif ($page >$totalPages){
            $page = $totalPages;
        }
        $link = "http://localhost:81/mywebsite.com/restaurants/show/page";
        $link = View::paginate($totalPages,$page,$link);
        $this->model->getRestaurant($page);
        $assoParam = helper::createAssoParams(["pageTitle","resInfo","links"],
                                              ["Mywebsite | Restaurants",$this->model->getResult(),$link]);
        $this->view("restaurants".DS."index",$assoParam);
    }
    public function search($q = "",$page = "1" ){
        if (!empty($q)) {
            if(!preg_match("/[0-9]/",$page)) {
                $page = 1;
            } else {
                $page = (int)$page;
            }
            // remember to filter out empty string if something goes wrong
            // for multiple search $filteredQuery = explode(" ",urldecode($q));
            $filteredQuery = urldecode($q);            
            $this->model("Restaurants");
            $filteredQuery = $this->model->searchQuery($filteredQuery);
            $this->model->count($filteredQuery["whereQuery"],$filteredQuery["whereParam"]);
            $totalResults = (int)$this->model->getResult()[0]["COUNT"];
            if ($totalResults == 0) {
                $this->view("error".DS."noresult",["pageTitle"=>"Mywebsite"]);
                exit();
            }
            $totalPages = ceil($totalResults/resultPerPage);
            if ($page < 1) {
                $page = 1;
            }
            elseif ($page >$totalPages){
                $page = $totalPages;
            }
            $link = "http://localhost:81/mywebsite.com/restaurants/search/$q/";
            $link = View::paginate($totalPages, $page, $link);
            $this->model->getRestaurant($page,$filteredQuery["whereQuery"],$filteredQuery["whereParam"]);
            $assoParam = helper::createAssoParams(["pageTitle","resInfo","links"],
                    ["Mywebsite | Restaurants",$this->model->getResult(),$link]);
            $this->view("restaurants".DS."index",$assoParam);
        } 
        else {
            header("Location: /mywebsite.com/restaurants");
            exit();
        }
    }
    public function detail($name = "") {
       if (empty($name)){
           header("Location: /mywebsite.com/restaurants");
           exit();
       }
       $this->model("Restaurants");
       $this->model->getDetail($name);
       $assoParam = helper::createAssoParams(["pageTitle","detail"],["Mywebsite | Restaurants",$this->model->getResult()]);
       $this->view("restaurants".DS."detail",$assoParam);
    }
}
