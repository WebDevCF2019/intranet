<?php






  // on sélectionne les détails de la section
  $detailsession = $thesessionM-> afficheSession();
  echo $twig->render("acceuilsession.html.twig",[ "detailsession"=>$detailsession]);
  

