<?php
class ajaxController extends Controller {
    public function index(){
        header("Location: /mywebsite.com/home");
        exit();
    }
    public function autocomplete(){
        if (filter_has_var(INPUT_POST, "getData")) {
            $input = json_decode($_POST["getData"]);
            $this->model("Restaurants");
            $this->model->getRestaurantName($input);
            $output = "<ul>";
            foreach ($this->model->getResult() as $v) {
                $output .= "<li>{$v["name"]}</li>";
            }
            $output .= "</ul>";
            echo $output;
        }
        else {
            header("Location: /mywebsite.com/home");
            exit();
        }
    }
}
