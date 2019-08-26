<?php


require_once "config.php";

require_once 'vendor/autoload.php';


$loader = new \Twig\Loader\FilesystemLoader('view/');
$twig = new \Twig\Environment($loader, [
    'debug' => !(PRODUCT),]);

$twig->addExtension(new Twig_Extensions_Extension_Text());

$twig->addExtension(new \Twig\Extension\DebugExtension());

spl_autoload_register(function($class){

       require_once 'model/' . $class . '.php'; 

});

try{
      $connexion = new MyPDO(
                'mysql:host=' . DB_HOST . ';dbname=' .DB_NAME . ';
                 port=' . DB_PORT .';charset=' . DB_CHARSET,
                 DB_LOGIN,
                 DB_PWD,
                 null,
                 PRODUCT);

      }catch (PDOException $e){


        echo "hehe".$e->getMessage();
        die();
      }



      $thesessionM = new sessionManager($connexion);






      require_once "controller/sessionController.php";


  

      

