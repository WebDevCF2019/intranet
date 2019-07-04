<?php


class thesection
{
    protected $intitule;
    protected $description;

    /**
     * thesection constructor.
     */
    public function __construct(array $datas=[])
    {
        if(empty($datas)){
            $this->setIntitule("Sans intitulé");
        }else{
            $this->hydrate($datas);
        }
    }

    protected function hydrate(array $values){
        foreach($values AS $key => $value){
            $setterName = "set".ucfirst($key);
            if(method_exists($this, $setterName)){
                $this->$setterName($value);
            }
        }
    }

    public function getItitule(): str
    {
        return $this->intitule;
    }

    public function setIntitule(int $intitule): void
    {
        if(!empty($intitule)) {
            $this->intitule = $intitule;
        }
    }

    public function getdescription()
    {
        if(empty($this->description)){
            return NULL;
        }else{
            return $this->description;
        }

    }

    public function setDescription(string $description): void
    {
        $this->description = htmlspecialchars(strip_tags(trim($description)),ENT_QUOTES);
    }
}
