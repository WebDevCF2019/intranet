<?php
class laFiliere {
    
    // clé étrangère
    protected $lafiliere_idfiliere;

    protected $idlafiliere;
    protected $lenom;
    protected $lacronyme;
    protected $lacouleur;
    protected $lepicto;


    //constructeur
    public function __construct(array $tab = [])
    {
        if (!empty($tab)) {
            $this->hydrate($tab);
        }
    }

    //Hydratation
    private function hydrate(array $datas){
        foreach ($datas as $key => $value){
            $setterName = "set".ucfirst($key);
            if(method_exists($this,$setterName)){
                $this->$setterName($value);
            }
        }
    }

    /**
     * Get the value of lafiliere_idfiliere
     */
    public function getLafiliere_idfiliere()
    {
        return $this->lafiliere_idfiliere;
    }

    /**
     * Set the value of lafiliere_idfiliere
     *
     * @return  self
     */ 
    public function setLafiliere_idfiliere($lafiliere_idfiliere)
    {
        $this->lafiliere_idfiliere = $lafiliere_idfiliere;

        return $this;
    }

    /**
     * Get the value of idlafiliere
     */ 
    public function getIdlafiliere()
    {
        return $this->idlafiliere;
    }

    /**
     * Set the value of idlafiliere
     *
     * @return  self
     */ 
    public function setIdlafiliere($idlafiliere)
    {
        $this->idlafiliere = $idlafiliere;

        return $this;
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
    public function setLenom($lenom)
    {
        $this->lenom = $lenom;

        return $this;
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
        $this->lacronyme = $lacronyme;

        return $this;
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
        $this->lacouleur = $lacouleur;

        return $this;
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
        $this->lepicto = $lepicto;

        return $this;
    }
}