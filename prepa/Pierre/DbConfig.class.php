<?php
include_once 'params.php';

class DbConfig {
    private $host = DB_HOSTNAME;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $database = DB_DATABASE;

    public $dbConn;

    public function __construct(){
        try {
            $this->dbConn = new PDO("mysql:host={$this->host};dbname={$this->database}",$this->username,$this->password);
            $this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->dbConn;
        } catch(PDOException $e) {
            echo "Echec de la connexion : ",$e->getMessage();
            return FALSE;
            exit();
        }
    }

    public function select($query){
        $result = $this->dbConn->query($query);

        if ($result == FALSE){
            return FALSE;
        }

        $rows = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $rows[]=$row;
        }
        return $rows;
    }


}

?>