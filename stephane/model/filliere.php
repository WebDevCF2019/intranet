<?php

class filliere{

   protected $idlafilliere;
   protected $lenom;
   protected $lacronyme;
   protected $lacouleur;
   protected $lepicto;

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
    * Get the value of idlafilliere
    */ 
   public function getIdlafilliere()
   {
      return $this->idlafilliere;
   }

   /**
    * Set the value of idlafilliere
    *
    * @return  self
    */ 
   public function setIdlafilliere( int $idlafilliere): void
   {
       if(!empty($idlafilliere)){
      $this->idlafilliere = $idlafilliere;
       }
      
   }


   
    /**
    * Get the value of lenom
    */ 
   public function getLenom()
   {
      return $this->lenom;
   }

   /**
    * Set the value of lenom
    *
    * @return  self
    */ 
   public function setLenom( string $lenom):void
   {
      $this->lenom = htmlspecialchars(strip_tags(trim ($lenom)), ENT_QUOTES);
    }




    /**
    * Get the value of lacronyme
    */ 
   public function getLacronyme()
   {
      return $this->lacronyme;
   }

   /**
    * Set the value of lacronyme
    *
    * @return  self
    */ 
   public function setLacronyme($lacronyme)
   {
      $this->lacronyme = htmlspecialchars(strip_tags(trim ($lacronyme)),ENT_QUOTES) ;

      
   }




    /**
    * Get the value of lacouleur
    */ 
   public function getLacouleur()
   {
      return $this->lacouleur;
   }

   /**
    * Set the value of lacouleur
    *
    * @return  self
    */ 
   public function setLacouleur($lacouleur)
   {
      $this->lacouleur = htmlspecialchars(strip_tags(trim($lacouleur)), ENT_QUOTES) ;

   }



   

   /**
    * Get the value of lepicto
    */ 
   public function getLepicto()
   {
      return $this->lepicto;
   }

   /**
    * Set the value of lepicto
    *
    * @return  self
    */ 
   public function setLepicto($lepicto)
   {
      $this->lepicto = htmlspecialchars(strip_tags(trim($lepicto)), ENT_QUOTES) ;

   }


}

//$test = new filliere();
//var_dump($test);