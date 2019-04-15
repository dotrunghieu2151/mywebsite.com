<?php 
    class helper {
        // dnd : dump and die, help with debugging
        public static function dnd($data){
           echo "<pre>";
           var_dump($data);
           echo "</pre>";
           die();
        }
        public static function createAssoParams($key = [], $val = []){
            return array_combine($key, $val);
        }
    }