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


  }


  /**
   * update de la filiere
   */

  elseif(isset($_GET['update'])&& ctype_digit($_GET['update'])&&!empty($_GET['update'])){

    $updateId = (int) $_GET['update'];

    $recupFiliere = $thefiliereM->updateFiliereParId($updateId);
var_dump($recupFiliere);
      if(empty($recupFiliere)){

        header("location: ./");
        exit();
        
      }

      if(empty($_POST)){
           
        echo $twig->render("updateFiliere.html.twig",["section"=>$recupFiliere]);
      }else{

         $update = new filiere($_POST);

         $updateFiliere = $thefiliereM->updateFiliere($update, $updateId);

         if($updateFiliere){
           header("location: ./");
         }else{
             
             echo $twig->render("updateFiliere.html.twig",["section"=>$recupFiliere]);
         }
      }
    

    }
    else {

      $filiere= $thefiliereM->selectionnerFiliereIndexPublic();
  
      echo $twig->render("accueilFilliere.html.twig", ["lemenu"=>$menu,"detailfiliere"=>$filiere]);
    }
    
  
  
