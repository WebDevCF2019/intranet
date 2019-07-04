<?php
/**
 * public
 */

 $menu = $thefiliereM->creerMenu();

 /**
  * 
  */

  if(isset($_GET['idlafiliere']) &&ctype_digit($_GET['idlafiliere'])){

//var_dump($idthefiliere);

    $idlafiliere = (int) $_GET['idlafiliere'];

    $detailFiliere = $thefiliereM->selectionnerFiliereParId($idlafiliere);

    echo $twig->render("accueilFilliere.html.twig",["lemenu"=>
    $menu, "detailfiliere"=>$detailFiliere]);


  }else {

    $filiere= $thefilliereM->selectionnerFiliereIndexPublic();

    echo $twig->render("accueilFilliere.html.twig", ["lemenu"=>$menu,"detailfiliere"=>$filiere]);
  }
  
