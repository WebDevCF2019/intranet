<?php

class utilisateur
{
	
	protected $idutilisateur;
	protected $username;
	protected $thepwd;
	protected $nom;
	protected $prenom;
	protected $themail;
	protected $uniqid;
	protected $datedebut;
	protected $datefin;

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
	
	public function getIdutilisateur()
	{
		return $this->idutilisateur;
	}
	
	public function setIdutilisateur(int $idutilisateur = null): void
	{
		if(!empty($idutilisateur)) {
			$this->idutilisateur = $idutilisateur;
		}
	}
	
	public function getUsername()
	{
		return $this->username;
	}
	
	public function setUsername(string $username = null): void
	{
		if(!empty($username)) {
			$this->username = htmlspecialchars(strip_tags(trim($username)), ENT_QUOTES);
		}
	}
	
	public function getThepwd()
	{
		return $this->thepwd;
	}
	
	public function setThepwd(string $thepwd = null): void
	{
		if(!empty($thepwd)) {
			$this->thepwd = htmlspecialchars(strip_tags(trim($thepwd)), ENT_QUOTES);
		}
	}
	
	public function getNom()
	{
		return $this->nom;
	}
	
	public function setNom(string $nom = null): void
	{
		if(!empty($nom)) {
			$this->nom = htmlspecialchars(strip_tags(trim($nom)), ENT_QUOTES);
		}
	}
	
	public function getPrenom()
	{
		return $this->prenom;
	}
	
	public function setPrenom(string $prenom = null): void
	{
		if(!empty($prenom)) {
			$this->prenom = htmlspecialchars(strip_tags(trim($prenom)), ENT_QUOTES);
		}
	}
	
	public function getThemail()
	{
		return $this->themail;
	}
	
	public function setThemail(string $themail = null): void
	{
		if(!empty($themail)) {
			$this->themail = htmlspecialchars(strip_tags(trim($themail)), ENT_QUOTES);
		}
	}
	
	public function getUniqid()
	{
		return $this->uniqid;
	}
	
	public function setUniqid(string $uniqid = null): void
	{
		if(!empty($uniqid)) {
			$this->uniqid = htmlspecialchars(strip_tags(trim($uniqid)), ENT_QUOTES);
		}
	}
	
	public function getDatedebut()
	{
		return $this->datedebut;
	}
	
	public function setDatedebut(string $datedebut = null): void
	{
		if(!empty($datedebut)) {
			$this->datedebut = htmlspecialchars(strip_tags(trim($datedebut)), ENT_QUOTES);
		}
	}
	
	public function getDatefin()
	{
		return $this->datefin;
	}
	
	public function setDatefin(string $datefin = null): void
	{
		if(!empty($datefin)) {
			$this->datefin = htmlspecialchars(strip_tags(trim($datefin)), ENT_QUOTES);
		}
	}
	
}

class utilisateurManager
{
	
	public static function displayContentUtilisateur(): array {
		global $PDOConnect;
	
		$sql = "
		DESCRIBE
			utilisateur;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->execute();
		
		return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function selectUtilisateur(int $id): array {
		global $PDOConnect;
	
		$sql = "
		SELECT
			*
		FROM
			utilisateur
		WHERE
			idutilisateur = :id;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->bindParam(":id", $id, PDO::PARAM_INT);
		$sqlQuery->execute();
		
		return $sqlQuery->fetch(PDO::FETCH_ASSOC);
	}
	
	public static function updateUtilisateur(int $id, array $datas) {
		global $PDOConnect;
		$updateDatas = "";
		foreach($datas as $dataField => $data) {
			$updateDatas .= $dataField . " = '" . $data . "', ";
		}
		$updateDatas = substr($updateDatas, 0, -2);
	
		$sql = "
		UPDATE
			utilisateur
		SET
			" . $updateDatas . "
		WHERE
			idutilisateur = :id;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->bindParam(":id", $id, PDO::PARAM_INT);
		$sqlQuery->execute();
	}
	
	public static function insertUtilisateur(array $datas): void {
		global $PDOConnect;
	
		$sql = "
		INSERT INTO utilisateur(username, thepwd, nom, prenom, themail, uniqid, datedebut, datefin)
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

	public static function deleteUtilisateur(int $id): void {
		global $PDOConnect;
	
		$sql = "
		DELETE
		FROM
			utilisateur
		WHERE
			idutilisateur = :id;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->bindParam(":id", $id, PDO::PARAM_INT);
		$sqlQuery->execute();
	}
	
	public static function selectAllUtilisateur(): array {
		global $PDOConnect;
	
		$sql = "
		SELECT
			*
		FROM
			utilisateur";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->execute();
		
		return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function selectUtilisateurJoinLerole(string $joinType = "inner"): array {
		global $PDOConnect;
		$joinType = strtolower($joinType);
		if($joinType !== "inner" && $joinType !== "left" && $joinType !== "right") {return [];}
	
		$sql = "
		SELECT
			utilisateur.idutilisateur AS utilisateur_idutilisateur, utilisateur.username AS utilisateur_username, utilisateur.thepwd AS utilisateur_thepwd, utilisateur.nom AS utilisateur_nom, utilisateur.prenom AS utilisateur_prenom, utilisateur.themail AS utilisateur_themail, utilisateur.uniqid AS utilisateur_uniqid, utilisateur.datedebut AS utilisateur_datedebut, utilisateur.datefin AS utilisateur_datefin, utilisateur_has_lerole.utilisateur_idutilisateur AS utilisateur_has_lerole_utilisateur_idutilisateur, utilisateur_has_lerole.lerole_idlerole AS utilisateur_has_lerole_lerole_idlerole, lerole.id AS lerole_id, lerole.intitule AS lerole_intitule, lerole.thedesc AS lerole_thedesc
		FROM
			utilisateur
		" . $joinType . " JOIN utilisateur_has_lerole ON utilisateur.idutilisateur = utilisateur_idutilisateur
		" . $joinType . " JOIN lerole ON lerole.id = lerole_idlerole;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->execute();
		
		return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
	}

}