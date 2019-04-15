<?php
class errorHandler {
    public function __construct($errorType){
        http_response_code($errorType);
        require VIEW . "error" . DS . "$errorType.phtml";
        exit();      
    }
}
