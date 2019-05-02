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
        public static function createPrepareParams($param) {
            $prepareParam = [];
            foreach ($param as $k => $v) {
                $prepareParam[":$k"] = $v;
            }
            return $prepareParam;
        }
        public static function splitAssoArray($array){
            $keys = implode(',',array_keys($array));
            $values = implode(',',array_values($array));
            return ["keys"=>$keys,"values"=>$values];
        }
        public static function debug($item){
            echo "<pre>";
            var_dump($item);
        }
    }