<?php

class ledroit
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

class ledroitManager
{
	
	public static function displayContentLedroit(): array {
		global $PDOConnect;
	
		$sql = "
		DESCRIBE
			ledroit;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->execute();
		
		return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function selectLedroit(int $id): array {
		global $PDOConnect;
	
		$sql = "
		SELECT
			*
		FROM
			ledroit
		WHERE
			id = :id;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->bindParam(":id", $id, PDO::PARAM_INT);
		$sqlQuery->execute();
		
		return $sqlQuery->fetch(PDO::FETCH_ASSOC);
	}
	
	public static function updateLedroit(int $id, array $datas) {
		global $PDOConnect;
		$updateDatas = "";
		foreach($datas as $dataField => $data) {
			$updateDatas .= $dataField . " = '" . $data . "', ";
		}
		$updateDatas = substr($updateDatas, 0, -2);
	
		$sql = "
		UPDATE
			ledroit
		SET
			" . $updateDatas . "
		WHERE
			id = :id;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->bindParam(":id", $id, PDO::PARAM_INT);
		$sqlQuery->execute();
	}
	
	public static function insertLedroit(array $datas): void {
		global $PDOConnect;
	
		$sql = "
		INSERT INTO ledroit(intitule, thedesc)
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

	public static function deleteLedroit(int $id): void {
		global $PDOConnect;
	
		$sql = "
		DELETE
		FROM
			ledroit
		WHERE
			id = :id;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->bindParam(":id", $id, PDO::PARAM_INT);
		$sqlQuery->execute();
	}
	
	public static function selectAllLedroit(): array {
		global $PDOConnect;
	
		$sql = "
		SELECT
			*
		FROM
			ledroit";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->execute();
		
		return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function selectLedroitJoinLerole(string $joinType = "inner"): array {
		global $PDOConnect;
		$joinType = strtolower($joinType);
		if($joinType !== "inner" && $joinType !== "left" && $joinType !== "right") {return [];}
	
		$sql = "
		SELECT
			ledroit.id AS ledroit_id, ledroit.intitule AS ledroit_intitule, ledroit.thedesc AS ledroit_thedesc, lerole_has_ledroit.lerole_id AS lerole_has_ledroit_lerole_id, lerole_has_ledroit.ledroit_id AS lerole_has_ledroit_ledroit_id, lerole.id AS lerole_id, lerole.intitule AS lerole_intitule, lerole.thedesc AS lerole_thedesc
		FROM
			ledroit
		" . $joinType . " JOIN lerole_has_ledroit ON ledroit.id = lerole_id
		" . $joinType . " JOIN lerole ON lerole.id = ledroit_id;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->execute();
		
		return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
	}

}