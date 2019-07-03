<?php

/**
*Lancement d'une session
*
*/

session_start();

/**
*Load dependencies
*/
require_once "config.php";

//composer vendor
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

/**
 * 
 * Create class autoload - find class int model's folder
 */

spl_autoload_register(function($class){
    require_once 'model/' . $class .'.php';
});


//connexion to db
try{
    $connexion = new MyPDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME .';port=' . DB_PORT .';charset=' . DB_CHARSET,
        DB_LOGIN,
        DB_PWD,
        null,
        PRODUCT);
    

    }catch (PDOException $e){
        echo $e->getMessage();
        die();
    }


    // create common's Managers

    $thefilliereM = new filliereManager($connexion);

    
    
    //on est connecté
    if(isset($_SESSION['mykey']) && $_SESSION['mykey']== session_id()){

      /**
       * admin
       */
      require_once "controler/filliereControler.php";

    }else{
        /**
         * public
         */

         require_once "controler/publicControler.php";
    }






