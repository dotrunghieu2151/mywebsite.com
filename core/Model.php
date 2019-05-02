<?php
class Model {
    protected $fields = [];
    protected $result;
    protected $pdo;
    protected $stmt;
    protected $sql;  
    protected $table = "";
    protected $serverName, $username, $password, $dbname, $charset;
    public function __construct(){
        $this->serverName = SERVERNAME;
        $this->username = DBUSERNAME;
        $this->password = DBPASS;
        $this->dbname = DBNAME;
        $this->charset = DBCHARSET;       
        try{
           $dsn = "mysql:host=$this->serverName;dbname=$this->dbname;charset=$this->charset";
           $this->pdo = new PDO($dsn, $this->username, $this->password);
           $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error) {
            echo "Connection failed: " . $error->getMessage();
        }
    }
    public function __destruct() {
        unset($this->pdo);
    }
    public function getResult() {
        return $this->result;
    }
    public function query($sql = "",$params = [], $returnVal = true) {
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute($params);
        if ($returnVal) {
            $this->result = ($this->stmt->rowCount() != 0) ? $this->stmt->fetchAll() : "No results found";
        }
    }
    public function getAll(){
        $this->sql = "SELECT * FROM $this->table";
        $this->query($this->sql,[],true); 
    }
    public function count($where = "",$whereParams = []) {
        $this->sql = "SELECT COUNT(*) AS COUNT FROM $this->table $where";
        $this->query($this->sql, $whereParams);
    }
    public function getLimit($offset,$limit,$where="",$whereParams=[]) {
        $this->sql = "SELECT * FROM $this->table $where LIMIT $offset,$limit ";
        $this->query($this->sql,$whereParams);
    }
    public function getLastInsertedID(){
        return $this->pdo->lastInsertId();
    }
    public function insert($param = []){
        $prepareParam = helper::createPrepareParams($param);
        $splitParam = helper::splitAssoArray($param);
        $splitPrepareParam = helper::splitAssoArray($prepareParam);
        $this->sql = "INSERT INTO $this->table({$splitParam["keys"]}) "
                   . "VALUES({$splitPrepareParam["keys"]})";
        $this->query($this->sql,$prepareParam,false);
        $this->result = $this->getLastInsertedID();
    }
    public function update($param = [], $where = "",$whereParam = [] ) {
        $updateList = "";
        foreach ($param as $k => $v) {
            $updateList .= "$k = :$k,";
        }
        $updateList = rtrim($updateList,',');
        $prepareParam = helper::createPrepareParams($param);
        $prepareParam = array_merge($prepareParam,$whereParam);
        $this->sql = "UPDATE $this->table SET $updateList $where ";
        $this->query($this->sql, $prepareParam, false);
        $this->result = ($this->$stmt->rowCount() != 0) ? $this->$stmt->rowCount() : "No update operation";
    }
    public function delete($where = "",$whereParam = []){
        $this->sql = "DELETE FROM $tbName $where ";
        $this->query($this->sql,$whereParam,false);
        $this->result = ($this->$stmt->rowCount() != 0) ? $this->$stmt->rowCount() : "No update operation";
    }
    public function searchQuery($query,$multiple = false){
        $where = "WHERE";
        $whereParam = [];
        if ($multiple) {
            $query = explode(" ",$query);
            foreach ($query as $q) {
                foreach($this->fields as $field) {
                    $where .= " $field REGEXP :$q OR";
                }         
                $whereParam[":$q"] = $q;
            }
        } 
        else {
           foreach ($this->fields as $field) {
               $where .= " $field REGEXP :query OR";
           }
           $whereParam[":query"] = $query;
        }
        $where = rtrim($where, "OR");
        return ["whereQuery"=>$where,"whereParam"=>$whereParam];
    }
}
