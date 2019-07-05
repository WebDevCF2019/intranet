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


}elseif (isset($_GET['add'])) {

    /*
     *
     * On veut ajouter une section
     *
     */

    // si on a pas cliqué "envoyé" sur le formulaire
    if (empty($_POST)) {


        // appel de la vue
        echo $twig->render("ajoutLutilisateur.html.twig");

    } else {

        // on crée une instance de thesection avec le formulaire POST en paramètre
        $insert = new lutilisateur($_POST);

        // on appel le manager et on utilise la méthode d'insertion (true en cas de réussite et false en cas d'échec)

        $forinsert = $theuserM->createUser($insert);

        // si l'insertion est réussie
        if ($forinsert) {
            header("Location: ./");
        } else {

            // appel de la vue avec affichage d'une erreur
            echo $twig->render("accueilutilisateur.html.twig", ["error" => "Erreur lors de l'insertion, veuillez recommencer"]);

        }

    }

}

else{
    $section = $theuserM->afficheUsersComplete();

// on appelle la vue générée par twig

    echo $twig->render('accueilutilisateur.html.twig',['section'=>$section]);
}
