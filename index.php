<?php

/*
 *
 *
 * Front Controller
 *
 *
 */

/*
 * Lancement d'une session
 */

session_start();

/*
 * Load Dependencies
 */

require_once "config.php";

// composer vendor loading (for twig)
require_once 'vendor/autoload.php';



// Initialize twig templating system - !(PRODUCT) => mod dev
$loader = new \Twig\Loader\FilesystemLoader('view/');
$twig = new \Twig\Environment($loader, [
    'debug' => !(PRODUCT),
    /* 'cache' => 'E:/WEB/PHP/CrudOO/cache/', */
]);
// twig extension for text
$twig->addExtension(new Twig_Extensions_Extension_Text());
// twig extension for debug
$twig->addExtension(new \Twig\Extension\DebugExtension());


/*
 * create class autoload - find class into model's folder
 */

spl_autoload_register(function ($class) {
    require_once 'model/' . $class . '.php';
});


// connexion to our DB
try {
    $connexion = new MyPDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';port=' . DB_PORT . ';charset=' . DB_CHARSET,
        DB_LOGIN,
        DB_PWD,
        null,
        PRODUCT);
} catch (PDOException $e) {
    echo $e->getMessage();
    die();
}


// create common's Managers

$thesectionM = new lafiliereManager($connexion);
$thestudentM = new lasessionManager($connexion);
$theuserM = new ledroitManager($connexion);
$theuserM = new leroleManager($connexion);
$theuserM = new lutilisateurManager($connexion);
$theuserM = new linscriptionManager($connexion);

// we're connected

if (isset($_SESSION['myKey']) && $_SESSION['myKey'] == session_id()) {

    /*
     * admin
     */
    require_once "controller/admin.php";
} else {

    /*
     * public
     */

    require_once "controller/admin.php";
}