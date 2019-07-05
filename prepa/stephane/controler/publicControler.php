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

    echo $twig->render("filiere/accueilFilliere.html.twig",["lemenu"=>
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
           
        echo $twig->render("filiere/updateFiliere.html.twig",["section"=>$recupFiliere]);
      }else{

         $update = new filiere($_POST);
var_dump($update);
         $updateFiliere = $thefiliereM->updateFiliere($update, $updateId);
         var_dump($updateFiliere);
         if($updateFiliere){
           header("location: ./");
         }else{
             
             echo $twig->render("filiere/updateFiliere.html.twig",["section"=>$recupFiliere]);
         }
      }



    
    //insert new filiere
    }elseif (isset($_GET['insert'])){

      if(empty($_POST)){


    // appel de la vue
    echo $twig->render("filiere/ajoutFiliere.html.twig");
      }

        else{

    // on crée une instance de thesection avec le formulaire POST en paramètre
    $insert = new filiere($_POST);

    // on appel le manager et on utilise la méthode d'insertion (true en cas de réussite et false en cas d'échec)

    $forinsert = $thefiliereM->createfiliere($insert);

    // si l'insertion est réussie
    if($forinsert){
        header("Location: ./");
    }else{

        // appel de la vue avec affichage d'une erreur
        echo $twig->render("admin/ajoutSectionAdmin.html.twig",["error"=>"Erreur lors de l'insertion, veuillez recommencer"]);

    }

  
  }
  
}elseif (isset($_GET['delete'])&&ctype_digit($_GET['delete'])&&!empty($_GET['delete'])){

    /*
     *
     * On veut supprimer une section
     *
     */


    $deleteId = (int) $_GET['delete'];

    // on utilise le manager pour supprimer la section
    $fordelete = $thefiliereM->deletefiliere($deleteId);

    header("Location: ./");



    }else {

      $filiere= $thefiliereM->selectionnerFiliereIndexPublic();
  
      echo $twig->render("filiere/accueilFilliere.html.twig", ["lemenu"=>$menu,"detailfiliere"=>$filiere]);
    }
  
    
  
  
