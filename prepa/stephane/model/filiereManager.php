<?php

class filiereManager {

    private $db; //connexion MyPDO

    public function __construct(MyPDO $connect)
    {
        $this->db = $connect;
    }

/**
 * 
 * Methode de la partie public
 * 
 */

 //creation du menu
 public function creerMenu(): array {
     $sql = "SELECT idlafiliere,lenom,lacronyme,lacouleur,lepicto FROM lafiliere ORDER BY lenom ASC;";
     $recup = $this->db->query($sql);

     if($recup->rowCount()===0){
         return[];
     }
     return $recup->fetchAll(PDO::FETCH_ASSOC);
 }

//creation de l'affichage
 public function selectionnerFiliereIndexPublic(): array{

    $sql = "SELECT * FROM lafiliere ORDER BY lenom ASC;";
    $recup = $this->db->query($sql);

    if($recup->rowCount()===0){
        return [];
    }
    return $recup->fetchAll(PDO::FETCH_ASSOC);
 }



 //recuperation d'une filiere par son ID
 public function selectionnerFiliereParId(int $idlafiliere): array{
     if(empty($idlafiliere)){
         return [];

     }
     $sql="SELECT * FROM lafiliere WHERE idlafiliere = ?;";
     $recup = $this->db->prepare($sql);
     $recup->bindValue(1,$idlafiliere,PDO::PARAM_INT);
     $recup->execute();

     if($recup->rowCount()===0){
         return [];
     }
      return $recup->fetchall(PDO::FETCH_ASSOC);
    
 }


}