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

class leroleManager
{
	
	public static function displayContentLerole(): array {
		global $PDOConnect;
	
		$sql = "
		DESCRIBE
			lerole;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->execute();
		
		return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function selectLerole(int $id): array {
		global $PDOConnect;
	
		$sql = "
		SELECT
			*
		FROM
			lerole
		WHERE
			id = :id;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->bindParam(":id", $id, PDO::PARAM_INT);
		$sqlQuery->execute();
		
		return $sqlQuery->fetch(PDO::FETCH_ASSOC);
	}
	
	public static function updateLerole(int $id, array $datas) {
		global $PDOConnect;
		$updateDatas = "";
		foreach($datas as $dataField => $data) {
			$updateDatas .= $dataField . " = '" . $data . "', ";
		}
		$updateDatas = substr($updateDatas, 0, -2);
	
		$sql = "
		UPDATE
			lerole
		SET
			" . $updateDatas . "
		WHERE
			id = :id;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->bindParam(":id", $id, PDO::PARAM_INT);
		$sqlQuery->execute();
	}
	
	public static function insertLerole(array $datas): void {
		global $PDOConnect;
	
		$sql = "
		INSERT INTO lerole(intitule, thedesc)
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

	public static function deleteLerole(int $id): void {
		global $PDOConnect;
	
		$sql = "
		DELETE
		FROM
			lerole
		WHERE
			id = :id;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->bindParam(":id", $id, PDO::PARAM_INT);
		$sqlQuery->execute();
	}
	
	public static function selectAllLerole(): array {
		global $PDOConnect;
	
		$sql = "
		SELECT
			*
		FROM
			lerole";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->execute();
		
		return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function selectLeroleJoinLedroit(string $joinType = "inner"): array {
		global $PDOConnect;
		$joinType = strtolower($joinType);
		if($joinType !== "inner" && $joinType !== "left" && $joinType !== "right") {return [];}
	
		$sql = "
		SELECT
			lerole.id AS lerole_id, lerole.intitule AS lerole_intitule, lerole.thedesc AS lerole_thedesc, lerole_has_ledroit.lerole_id AS lerole_has_ledroit_lerole_id, lerole_has_ledroit.ledroit_id AS lerole_has_ledroit_ledroit_id, ledroit.id AS ledroit_id, ledroit.intitule AS ledroit_intitule, ledroit.thedesc AS ledroit_thedesc
		FROM
			lerole
		" . $joinType . " JOIN lerole_has_ledroit ON lerole.id = lerole_id
		" . $joinType . " JOIN ledroit ON ledroit.id = ledroit_id;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->execute();
		
		return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function selectLeroleJoinUtilisateur(string $joinType = "inner"): array {
		global $PDOConnect;
		$joinType = strtolower($joinType);
		if($joinType !== "inner" && $joinType !== "left" && $joinType !== "right") {return [];}
	
		$sql = "
		SELECT
			lerole.id AS lerole_id, lerole.intitule AS lerole_intitule, lerole.thedesc AS lerole_thedesc, utilisateur_has_lerole.utilisateur_idutilisateur AS utilisateur_has_lerole_utilisateur_idutilisateur, utilisateur_has_lerole.lerole_idlerole AS utilisateur_has_lerole_lerole_idlerole, utilisateur.idutilisateur AS utilisateur_idutilisateur, utilisateur.username AS utilisateur_username, utilisateur.thepwd AS utilisateur_thepwd, utilisateur.nom AS utilisateur_nom, utilisateur.prenom AS utilisateur_prenom, utilisateur.themail AS utilisateur_themail, utilisateur.uniqid AS utilisateur_uniqid, utilisateur.datedebut AS utilisateur_datedebut, utilisateur.datefin AS utilisateur_datefin
		FROM
			lerole
		" . $joinType . " JOIN utilisateur_has_lerole ON lerole.id = utilisateur_idutilisateur
		" . $joinType . " JOIN utilisateur ON utilisateur.idutilisateur = lerole_idlerole;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->execute();
		
		return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
	}

}