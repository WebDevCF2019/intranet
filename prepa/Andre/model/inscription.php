<?php

class inscription
{
	
	protected $idinscription;
	protected $debut;
	protected $fin;
	protected $utilisateur_idutilisateur;
	protected $session_idsession;
	protected $session_filiere_idfiliere;

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
	
	public function getIdinscription()
	{
		return $this->idinscription;
	}
	
	public function setIdinscription(int $idinscription = null): void
	{
		if(!empty($idinscription)) {
			$this->idinscription = $idinscription;
		}
	}
	
	public function getDebut()
	{
		return $this->debut;
	}
	
	public function setDebut(string $debut = null): void
	{
		if(!empty($debut)) {
			$this->debut = htmlspecialchars(strip_tags(trim($debut)), ENT_QUOTES);
		}
	}
	
	public function getFin()
	{
		return $this->fin;
	}
	
	public function setFin(string $fin = null): void
	{
		if(!empty($fin)) {
			$this->fin = htmlspecialchars(strip_tags(trim($fin)), ENT_QUOTES);
		}
	}
	
	public function getUtilisateur_idutilisateur()
	{
		return $this->utilisateur_idutilisateur;
	}
	
	public function setUtilisateur_idutilisateur(int $utilisateur_idutilisateur = null): void
	{
		if(!empty($utilisateur_idutilisateur)) {
			$this->utilisateur_idutilisateur = $utilisateur_idutilisateur;
		}
	}
	
	public function getSession_idsession()
	{
		return $this->session_idsession;
	}
	
	public function setSession_idsession(int $session_idsession = null): void
	{
		if(!empty($session_idsession)) {
			$this->session_idsession = $session_idsession;
		}
	}
	
	public function getSession_filiere_idfiliere()
	{
		return $this->session_filiere_idfiliere;
	}
	
	public function setSession_filiere_idfiliere(int $session_filiere_idfiliere = null): void
	{
		if(!empty($session_filiere_idfiliere)) {
			$this->session_filiere_idfiliere = $session_filiere_idfiliere;
		}
	}
	
}

class inscriptionManager
{
	
	public static function displayContentInscription(): array {
		global $PDOConnect;
	
		$sql = "
		DESCRIBE
			inscription;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->execute();
		
		return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function selectInscription(int $id): array {
		global $PDOConnect;
	
		$sql = "
		SELECT
			*
		FROM
			inscription
		WHERE
			idinscription = :id;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->bindParam(":id", $id, PDO::PARAM_INT);
		$sqlQuery->execute();
		
		return $sqlQuery->fetch(PDO::FETCH_ASSOC);
	}
	
	public static function updateInscription(int $id, array $datas) {
		global $PDOConnect;
		$updateDatas = "";
		foreach($datas as $dataField => $data) {
			$updateDatas .= $dataField . " = '" . $data . "', ";
		}
		$updateDatas = substr($updateDatas, 0, -2);
	
		$sql = "
		UPDATE
			inscription
		SET
			" . $updateDatas . "
		WHERE
			idinscription = :id;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->bindParam(":id", $id, PDO::PARAM_INT);
		$sqlQuery->execute();
	}
	
	public static function insertInscription(array $datas): void {
		global $PDOConnect;
	
		$sql = "
		INSERT INTO inscription(debut, fin, utilisateur_idutilisateur, session_idsession, session_filiere_idfiliere)
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

	public static function deleteInscription(int $id): void {
		global $PDOConnect;
	
		$sql = "
		DELETE
		FROM
			inscription
		WHERE
			idinscription = :id;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->bindParam(":id", $id, PDO::PARAM_INT);
		$sqlQuery->execute();
	}
	
	public static function selectAllInscription(): array {
		global $PDOConnect;
	
		$sql = "
		SELECT
			*
		FROM
			inscription";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->execute();
		
		return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
	}
	
}