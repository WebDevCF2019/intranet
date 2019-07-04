<?php   



class sessionManager{



private $db;

    public function __construct(myPDO $connect){

     $this ->db =$connect;
}

  public function sessionid(): array {


$sql="SELECT * FROM lasession;";
$recup=$this->db->query($sql);
if($recup->rowCount()===0){
   return[];

} 
return $recup->fetchAll(PDO::FETCH_ASSOC);

  }


  public function creerMenu(): array
  {
    $sql = "SELECT * FROM lasession ORDER BY lenom ASC ;";
    $recup = $this->db->query($sql);

    if ($recup->rowCount() === 0) {
      return [];
    }
    return $recup->fetchAll(PDO::FETCH_ASSOC);
  }






}


