<?php
$menu = $thesessionM->creerMenu();

if (isset($_GET['idlasession']) &&ctype_digit($_GET['idlasession'])){
     
    $idsession =(int) $_GET['idlasession'];

    $detailsession = $thesessionM -> sessionid($idsession);
  echo $twig->render("aceuilsesion.html.twig",["detaisession"=>$detailsession]);

}else{

 echo $twig->render("acceuilsession.html.twig");

}

