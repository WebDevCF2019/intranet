<?php

require_once "../config.php";

try {
	$PDOConnect = new PDO(
		"mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT . ";charset=" . DB_CHARSET,
		DB_LOGIN,
		DB_PWD,
		null);
} catch (PDOException $e) {
	echo $e->getMessage();
	die();
}

include "../models/filiere.php";
include "../models/inscription.php";
include "../models/ledroit.php";
include "../models/lerole.php";
include "../models/session.php";
include "../models/utilisateur.php";
