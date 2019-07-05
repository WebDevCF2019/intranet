<?php

$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

mysqli_select_db($conn,'intranetv2');

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
	


	public function add_role($conn,$role){
		$intitule = $role->getIntitule();
		$desc = $role->getThedesc();
		$tcheck = $conn->query("select intitule,thedesc from lerole;");
		$intitules = [];
		$descriptions = [];
		while ($row = mysqli_fetch_assoc($tcheck)) {
			array_push($intitules,$row["intitule"]);
			array_push($descriptions,$row["thedesc"]);}
		var_dump($intitules,$descriptions);	
		if(in_array($intitule,$intitules) == false and in_array($desc,$descriptions)==false){
		$conn->query("INSERT INTO lerole (idlerole, intitule, thedesc) VALUES (NULL, '$intitule' , '$desc');");}
	}
	
	}

	$issou = new lerole(['intitule'=>'putain2','thedesc'=>'putaindescriptible2']);

	$issou->add_role($conn,$issou);