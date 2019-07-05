<?php

class filiere
{
	
	protected $idfiliere;
	protected $lenom;
	protected $lacronyme;
	protected $lacouleur;
	protected $lepicto;

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
	
	public function getIdfiliere()
	{
		return $this->idfiliere;
	}
	
	public function setIdfiliere(int $idfiliere = null): void
	{
		if(!empty($idfiliere)) {
			$this->idfiliere = $idfiliere;
		}
	}
	
	public function getLenom()
	{
		return $this->lenom;
	}
	
	public function setLenom(string $lenom = null): void
	{
		if(!empty($lenom)) {
			$this->lenom = htmlspecialchars(strip_tags(trim($lenom)), ENT_QUOTES);
		}
	}
	
	public function getLacronyme()
	{
		return $this->lacronyme;
	}
	
	public function setLacronyme(string $lacronyme = null): void
	{
		if(!empty($lacronyme)) {
			$this->lacronyme = htmlspecialchars(strip_tags(trim($lacronyme)), ENT_QUOTES);
		}
	}
	
	public function getLacouleur()
	{
		return $this->lacouleur;
	}
	
	public function setLacouleur(string $lacouleur = null): void
	{
		if(!empty($lacouleur)) {
			$this->lacouleur = htmlspecialchars(strip_tags(trim($lacouleur)), ENT_QUOTES);
		}
	}
	
	public function getLepicto()
	{
		return $this->lepicto;
	}
	
	public function setLepicto(string $lepicto = null): void
	{
		if(!empty($lepicto)) {
			$this->lepicto = htmlspecialchars(strip_tags(trim($lepicto)), ENT_QUOTES);
		}
	}
	
}

class filiereManager
{
	
	public static function displayContentFiliere(): array {
		global $PDOConnect;
	
		$sql = "
		DESCRIBE
			filiere;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->execute();
		
		return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function selectFiliere(int $id): array {
		global $PDOConnect;
	
		$sql = "
		SELECT
			*
		FROM
			filiere
		WHERE
			idfiliere = :id;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->bindParam(":id", $id, PDO::PARAM_INT);
		$sqlQuery->execute();
		
		return $sqlQuery->fetch(PDO::FETCH_ASSOC);
	}
	
	public static function updateFiliere(int $id, array $datas) {
		global $PDOConnect;
		$updateDatas = "";
		foreach($datas as $dataField => $data) {
			$updateDatas .= $dataField . " = '" . $data . "', ";
		}
		$updateDatas = substr($updateDatas, 0, -2);
	
		$sql = "
		UPDATE
			filiere
		SET
			" . $updateDatas . "
		WHERE
			idfiliere = :id;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->bindParam(":id", $id, PDO::PARAM_INT);
		$sqlQuery->execute();
	}
	
	public static function insertFiliere(array $datas): void {
		global $PDOConnect;
	
		$sql = "
		INSERT INTO filiere(lenom, lacronyme, lacouleur, lepicto)
		VALUES
			(";
		foreach($datas as $data) {
			$sql .= (gettype($data) == "string" ? "'" . $data . "'" : $data) . ", ";
		}
		$sql = substr($sql, 0, -2);
		$sql .= ");";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->execute();
	}

	public static function deleteFiliere(int $id): void {
		global $PDOConnect;
	
		$sql = "
		DELETE
		FROM
			filiere
		WHERE
			idfiliere = :id;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->bindParam(":id", $id, PDO::PARAM_INT);
		$sqlQuery->execute();
	}
	
	public static function selectAllFiliere(): array {
		global $PDOConnect;
	
		$sql = "
		SELECT
			*
		FROM
			filiere";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->execute();
		
		return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
	}
	
}