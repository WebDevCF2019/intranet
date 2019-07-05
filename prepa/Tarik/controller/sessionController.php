<?php


 echo $twig->render("acceuilsession.html.twig");



if (isset($_GET['idlasession']) && ctype_digit($_GET['idlasession'])) {

  $idsession = (int) $_GET['idlasession'];

  // on sélectionne les détails de la section
  $detailsession = $thesessionM-> afficheSession($idsession);
  echo $twig->render("acceuilsession.html.twig",[ "detailsession"=>$detailsession]);
   var_dump($detailsession);
}
