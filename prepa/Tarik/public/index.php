<?php

/* 
 * 
 * Front Controller
 * 
 * 
 */

/*
 * configuration
 */
require_once '../config.php';

/*
 * vendor autoload for
 * - Twig
 * - Twig extensions
 */
require_once '../vendor/autoload.php';

/*
 * autoload for our models
 */
spl_autoload_register(function ($class) {
    include '../model/' . $class . '.php';
});


$loader = new \Twig\Loader\FilesystemLoader('view/');
$twig = new \Twig\Environment($loader, [
    'debug' => !(PRODUCT),
]);

$twig->addExtension(new Twig_Extensions_Extension_Text());

$twig->addExtension(new \Twig\Extension\DebugExtension());
/*
 * create a PDO connection with MyPDO
 */
$db_connect = new MyPDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME .';port=' . DB_PORT .';charset=' . DB_CHARSET,
        DB_LOGIN,
        DB_PWD,
        null,
        PRODUCT);