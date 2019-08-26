<?php

class inscription{

   protected $idlinscription;
   protected $debut;
   protected $fin;
   protected $utilisateur_idutilisateur;
   protected $lasession_idsession;

/**
 * filliere constructor
 */
public function __construct(array $datas=[])
{
    if (!empty($datas)){
         $this->hydrate($datas);
    }
    
}

protected function hydrate(array $values){
    foreach($values AS $key => $values){
        $setterName = "set".ucfirst($key);
        if(method_exists($this, $setterName)){
            $this->$setterName($values);
        }
  }
}



    /**
    * Get the value of idlinscription
    */ 
   public function getIdlinscription()
   {
      return $this->idlinscription;
   }

   /**
    * Set the value of idlinscription
    *
    * @return  self
    */ 
   public function setIdlinscription( int $idlinscription): void
   {
       if(!empty($idlinscription)){
      $this->idlinscription = $idlinscription;
       }
      
   }


   
    /**
    * Get the value of debut
    */ 
   public function getDebut()
   {
      return $this->debut;
   }

   /**
    * Set the value of debut
    *
    * @return  self
    */ 
   public function setDebut( string $debut):void
   {
      $this->debut = htmlspecialchars(strip_tags(trim ($debut)), ENT_QUOTES);
    }




    /**
    * Get the value of fin
    */ 
   public function getFin()
   {
      return $this->fin;
   }

   /**
    * Set the value of fin
    *
    * @return  self
    */ 
   public function setFin($fin)
   {
      $this->fin = htmlspecialchars(strip_tags(trim ($fin)),ENT_QUOTES) ;

      
   }




    /**
    * Get the value of utilisateur_idutilisateur
    */ 
   public function getUtilisateur_idutilisateur()
   {
      return $this->utilisateur_idutilisateur;
   }

   /**
    * Set the value of utilisateur_idutilisateur
    *
    * @return  self
    */ 
   public function settilisateur_idutilisateur($utilisateur_idutilisateur)
   {
      $this->utilisateur_idutilisateur = htmlspecialchars(strip_tags(trim($utilisateur_idutilisateur)), ENT_QUOTES) ;

   }



   

   /**
    * Get the value of lasession_idsession
    */ 
   public function getLasession_idsession()
   {
      return $this->lasession_idsession;
   }

   /**
    * Set the value of lasession_idsession
    *
    * @return  self
    */ 
   public function setLasession_idsession($lasession_idsession)
   {
      $this->lasession_idsession = htmlspecialchars(strip_tags(trim($lasession_idsession)), ENT_QUOTES) ;

   }


}

//$test = new inscription();
//var_dump($test);