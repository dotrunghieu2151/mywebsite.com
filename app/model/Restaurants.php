<?php
class Restaurants extends Model {
    public function __construct() {
        parent::__construct();
        $this->table = "restaurants";
        $this->fields = ["name","location","openTime","description"];
    }
    public function getRestaurantName($query){
        $this->sql = "SELECT name FROM $this->table WHERE name REGEXP :query";
        $this->query($this->sql,[":query"=>$query]);
    }
    public function getRestaurant($currPage,$where = "",$whereParam = []){
       $offset = ($currPage-1)*resultPerPage;
       $this->getLimit($offset,resultPerPage,$where,$whereParam);  
    }
    public function getDetail($resName){
        $this->sql = "SELECT * FROM $this->table WHERE urlName = :resName";
        $this->query($this->sql, [":resName"=>$resName]);
    }
}
