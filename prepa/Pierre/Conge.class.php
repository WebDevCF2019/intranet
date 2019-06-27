<?php

include_once 'DbConfig.class.php';

class Conge {
    protected $dbConn;

    public function __construct($sessionID) {
        $this->dbConn = new DbConfig();

        echo "Congés associés à la session id=".$sessionID;

        $result = $this->dbConn->select("SELECT debut,fin,type FROM conges WHERE session_id=".$sessionID);
        
        foreach($result as $cle=>$valeur){
            switch($valeur['type']){
                case 1: $type="matin"; break;
                case 2: $type="après-midi"; break;
                case 3: $type="toute la journée"; break;
                default: $type="autre";
            }
            echo "<p>Congé du ".$valeur['debut']." au ".$valeur['fin']." : ".$type."</p>";
            //print_r($valeur);
        }
    }

}
?>