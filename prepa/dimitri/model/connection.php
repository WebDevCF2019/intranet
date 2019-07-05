<?php
require_once('config.php');

//connect to db
try {

    $ddb = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';port=' . DB_PORT . ';charset=' . DB_CHARSET,
        DB_LOGIN,
        DB_PWD);

    $ddb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo 'Connection échoué !' . $e->getMessage();
    die();
}
