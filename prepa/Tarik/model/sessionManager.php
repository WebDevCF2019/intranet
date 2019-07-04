<?php   



class sessionManager{



private $db;

    public function __construct(myPDO $connect){

     $this ->db =$connect;



    }

   public function creerMenu(): array {


  $sql= "SELECT lenom, lacronyme FROM lasession ORDER BY lenom ASC;";
   $recup =$this->db->query($sql);
   if($recup->rowCount()===0){

         return[];

   }
     return $recup->fetchAll(PDO::FETCH_ASSOC);


   }







}



