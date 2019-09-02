<?php


class lutilisateur
{
protected $idutilisateur;
protected $lenomutilisateur;
protected $lemotdepasse;
protected $lenom;
protected $leprenom;
protected $lemail;
protected $luniqueid;

//méthodes

public function __construct (array $data = [])
{
    if(!empty($data)){       
        $this->hydrate($data);
    }
}

protected function hydrate (array $tablehydrate ){
    foreach ($tablehydrate AS $key=>$value){
        $setterName = "set".ucfirst($key);
        if(method_exists($this,$setterName)){
            $this->$setterName($value);
        }
    }
}

    /**
     * GETTERS
     */
    public function getIdutilisateur()
    {
        return htmlspecialchars_decode($this->idutilisateur,ENT_QUOTES);
    }

    /**
     * @return mixed
     */
    public function getLenomutilisateur()
    {
        return $this->lenomutilisateur;
    }

    /**
     * @return mixed
     */
  public function getLemotdepasse()
    {
        return $this->lemotdepasse;
    }

    /**
     * @return mixed
     */
    public function getLenom()
    {
        return $this->lenom;
    }

    /**
     * @return mixed
     */
    public function getLeprenom()
    {
        return $this->leprenom;
    }

    /**
     * @return mixed
     */
    public function getLemail()
    {
        return $this->lemail;
    }

    /**
     * @return mixed
     */
    
    public function getLuniqueid()
    {
        return $this->luniqueid;
    }

    /**
     * SETTERS
     */
    public function setIdutilisateur( int $idutilisateur)
    {
        if(!empty($idutilisateur)){

            $this->idutilisateur = $idutilisateur;
        }
    }

    /**
     * @param mixed $lenomutilisateur
     */
    public function setLenomutilisateur (string $lenomutilisateur)
    {
        $this->lenomutilisateur =htmlspecialchars(strip_tags(trim($lenomutilisateur)),ENT_QUOTES);
    }

    /**
     * @param mixed $lemotdepasse
     */
    public function setLemotdepasse($lemotdepasse)
    {
        $this->lemotdepasse = password_hash((trim($lemotdepasse)), PASSWORD_DEFAULT);
    }

    /**
     * @param mixed $lenom
     */

    public function setLenom( string $lenom)
    {
        $this->lenom = htmlspecialchars(strip_tags(trim($lenom)),ENT_QUOTES);
    }

    /**
     * @param mixed $leprenom
     */
    public function setLeprenom( string $leprenom)
    {
        $this->leprenom = htmlspecialchars(strip_tags(trim($leprenom)),ENT_QUOTES);
    }

    /**
     * @param mixed $lemail
     */
    public function setLemail(string $lemail)
    {
        $this->lemail =htmlspecialchars(strip_tags(trim($lemail)),ENT_QUOTES);
    }

    /**
     * @param mixed $luniqueid
     */
    
    public function setLuniqueid( string $luniqueid='')
    {
        if(empty($luniqueid)){
            $this->luniqueid = $uniqid('key',true);
        }else{
            $this->luniqueid = $luniqueid;
        }
    }



}


