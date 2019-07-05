<?php

class lerole
{
	
	protected $id;
	protected $intitule;
	protected $thedesc;

	public function __construct(array $datas=[])
	{
		if(empty($datas)){
			echo "Aucun array de données fourni";
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
	
	public function getId()
	{
		return $this->id;
	}
	
	public function setId(int $id = null): void
	{
		if(!empty($id)) {
			$this->id = $id;
		}
	}
	
	public function getIntitule()
	{
		return $this->intitule;
	}
	
	public function setIntitule(string $intitule = null): void
	{
		if(!empty($intitule)) {
			$this->intitule = htmlspecialchars(strip_tags(trim($intitule)), ENT_QUOTES);
		}
	}
	
	public function getThedesc()
	{
		return $this->thedesc;
	}
	
	public function setThedesc(string $thedesc = null): void
	{
		if(!empty($thedesc)) {
			$this->thedesc = htmlspecialchars(strip_tags(trim($thedesc)), ENT_QUOTES);
		}
	}
	
}