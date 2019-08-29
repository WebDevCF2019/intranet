<?php


class ledroit{

   protected $idledroit;
   protected $ladescription;
   protected $lintitule;


/**
 * ledroit constructor
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
    * Get the value of idledroit
    */ 
   public function getIdledroit()
   {
      return $this->idledroit;
   }

   /**
    * Set the value of idledroit
    *
    * @return  self
    */ 
   public function setIdledroit( int $idledroit): void
   {
       if(!empty($idledroit)){
      $this->idledroit = $idledroit;
       }
      
   }

    /**
    * Get the value of ladescription
    */ 
   public function getLadescription()
   {
      return $this->ladescription;
   }

   /**
    * Set the value of ladescription
    *
    * @return  self
    */ 
   public function setLadescription( string $ladescription):void
   {
      $this->ladescription = htmlspecialchars(strip_tags(trim ($ladescription)), ENT_QUOTES);
    }

    /**
    * Get the value of lintitule
    */ 
   public function getLintitule()
   {
      return $this->lintitule;
   }

   /**
    * Set the value of lintitule
    *
    * @return  self
    */ 
   public function setLintitule($lintitule)
   {
      $this->lintitule = htmlspecialchars(strip_tags(trim ($lintitule)),ENT_QUOTES) ;

      
   }

}
