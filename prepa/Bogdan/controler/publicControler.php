<?php


if (isset($_GET['delete'])&&ctype_digit($_GET['delete'])&&!empty($_GET['delete'])){

    /*
     *
     * On veut supprimer une section
     *
     */


    $delete = (int) $_GET['delete'];

    // on utilise le manager pour supprimer la section
    $fordelete = $theuserM->deleteStudentById($delete);

    header("Location: ./");


}elseif (isset($_GET['add'])){

    if(empty($_POST)){


        // appel de la vue
        echo $twig->render("updateLutilisateur.html.twig");
    }

    else{

        // on crée une instance de thesection avec le formulaire POST en paramètre
        $insert = new lutilisateur($_POST);

        // on appel le manager et on utilise la méthode d'insertion (true en cas de réussite et false en cas d'échec)

        $forinsert = $theuserM->createUser($insert);

        // si l'insertion est réussie
        if($forinsert){
            header("Location: ./");
        }else{

            // appel de la vue avec affichage d'une erreur
            echo $twig->render("accueilutilisateur.html.twig",["error"=>"Erreur lors de l'insertion, veuillez recommencer"]);

        }


    }

}elseif (isset($_GET['update'])&&ctype_digit($_GET['update'])&&!empty($_GET['update'])) {

    /*
     *
     * On veut modifier une section
     *
     */


    $updateId = (int)$_GET['update'];

    // on récupère la section avec son manager et grâce à son id

    $recupUser = $theuserM->afficheUsers($updateId);

    // on n'arrive pas à récupéré la section pour la modifier
    if (empty($recupUser)) {

        // redirection vers l'accueil
        header("Location: ./");
        exit();

    }

    // pas envoyé
    if (empty($_POST)) {

        // appel de la vue
        echo $twig->render("updateLutilisateur.html.twig", ["contenu" => $recupUser]);

    } else {

        // on crée une instance de type thesection avec le contenu du formulaire en paramètre
        $update = new lutilisateur($_POST);

        // var_dump($update);
        // utilisation du manager de thesection pour mettre à jour

        $forupdate = $theuserM->updateUser($update, $updateId);

        if ($forupdate) {
            header("Location: ./");
        } else {
            echo $twig->render("updateLutilisateur.html.twig", ["contenu" => $recupUser]);
        }

    }
}

else{
    $section = $theuserM->afficheUsers();

// on appelle la vue générée par twig

    echo $twig->render('accueilutilisateur.html.twig',['section'=>$section]);
}
