<?php

class session
{
	
	protected $idsession;
	protected $lenom;
	protected $lacronyme;
	protected $lannee;
	protected $lenumero;
	protected $letype;
	protected $debut;
	protected $fin;
	protected $filiere_idfiliere;

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
	
	public function getIdsession()
	{
		return $this->idsession;
	}
	
	public function setIdsession(int $idsession = null): void
	{
		if(!empty($idsession)) {
			$this->idsession = $idsession;
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
	
	public function getLannee()
	{
		return $this->lannee;
	}
	
	public function setLannee(string $lannee = null): void
	{
		if(!empty($lannee)) {
			$this->lannee = htmlspecialchars(strip_tags(trim($lannee)), ENT_QUOTES);
		}
	}
	
	public function getLenumero()
	{
		return $this->lenumero;
	}
	
	public function setLenumero(int $lenumero = null): void
	{
		if(!empty($lenumero)) {
			$this->lenumero = $lenumero;
		}
	}
	
	public function getLetype()
	{
		return $this->letype;
	}
	
	public function setLetype(int $letype = null): void
	{
		if(!empty($letype)) {
			$this->letype = $letype;
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
	
	public function getFiliere_idfiliere()
	{
		return $this->filiere_idfiliere;
	}
	
	public function setFiliere_idfiliere(int $filiere_idfiliere = null): void
	{
		if(!empty($filiere_idfiliere)) {
			$this->filiere_idfiliere = $filiere_idfiliere;
		}
	}
	
}

class sessionManager
{
	
	public static function displayContentSession(): array {
		global $PDOConnect;
	
		$sql = "
		DESCRIBE
			session;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->execute();
		
		return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public static function selectSession(int $id): array {
		global $PDOConnect;
	
		$sql = "
		SELECT
			*
		FROM
			session
		WHERE
			idsession = :id;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->bindParam(":id", $id, PDO::PARAM_INT);
		$sqlQuery->execute();
		
		return $sqlQuery->fetch(PDO::FETCH_ASSOC);
	}
	
	public static function updateSession(int $id, array $datas) {
		global $PDOConnect;
		$updateDatas = "";
		foreach($datas as $dataField => $data) {
			$updateDatas .= $dataField . " = '" . $data . "', ";
		}
		$updateDatas = substr($updateDatas, 0, -2);
	
		$sql = "
		UPDATE
			session
		SET
			" . $updateDatas . "
		WHERE
			idsession = :id;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->bindParam(":id", $id, PDO::PARAM_INT);
		$sqlQuery->execute();
	}
	
	public static function insertSession(array $datas): void {
		global $PDOConnect;
	
		$sql = "
		INSERT INTO session(lenom, lacronyme, lannee, lenumero, letype, debut, fin, filiere_idfiliere)
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

	public static function deleteSession(int $id): void {
		global $PDOConnect;
	
		$sql = "
		DELETE
		FROM
			session
		WHERE
			idsession = :id;";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->bindParam(":id", $id, PDO::PARAM_INT);
		$sqlQuery->execute();
	}
	
	public static function selectAllSession(): array {
		global $PDOConnect;
	
		$sql = "
		SELECT
			*
		FROM
			session";
		$sqlQuery = $PDOConnect->prepare($sql);
		$sqlQuery->execute();
		
		return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
	}
	
}