<?php




 $menu =$thesectionM->creerMenu();

if (isset($_GET['idthesection']) && ctype_digit($_GET['idthesection'])) {

    $idsection = (int) $_GET['idthesection'];
 echo $twig->render("aceuilsession.html.twig",["session"=>$menu]);
  



}