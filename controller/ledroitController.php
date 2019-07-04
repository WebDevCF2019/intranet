<?php
/*
 *
 * LE DROIT ADMIN
 *
 */





if (isset($_GET['disconnect'])) {

    /*
     *
     * On se déconnecte (la redirection est inclue dans le modèle)
     *
     */

    $theuserM->deconnecterSession();

    // on veut gérer les étudiants
}elseif(isset($_GET['adminLedroit'])){

    /*
     *
     * Appel du contrôleur gérant les étudiants
     *
     * !!!!! la variable get adminstudent doit toujours rester dans l'url tant que l'on veut gérer les étudients
     *
     */
    require_once "studentController.php";

}elseif (isset($_GET['delete'])&&ctype_digit($_GET['delete'])&&!empty($_GET['delete'])){

    /*
     *
     * On veut supprimer une section
     *
     */


    $deleteId = (int) $_GET['delete'];

    // on utilise le manager pour supprimer la section
    $fordelete = $thesectionM->deleteSection($deleteId);

    header("Location: ./");



}elseif (isset($_GET['update'])&&ctype_digit($_GET['update'])&&!empty($_GET['update'])){

    /*
     *
     * On veut modifier une section
     *
     */


    $updateId = (int) $_GET['update'];

    // on récupère la section avec son manager et grâce à son id

    $recupSection = $thesectionM->selectionnerSectionParId($updateId);

    // on n'arrive pas à récupéré la section pour la modifier
    if(empty($recupSection)){

        // redirection vers l'accueil
        header("Location: ./");
        exit();

    }

    // pas envoyé
    if(empty($_POST)){

        // appel de la vue
        echo $twig->render("admin/updateSectionAdmin.html.twig",["contenu"=>$recupSection]);

    }else{

        // on crée une instance de type thesection avec le contenu du formulaire en paramètre
        $update = new thesection($_POST);

        // var_dump($update);
        // utilisation du manager de thesection pour mettre à jour

        $forupdate = $thesectionM->updateSection($update,$updateId);

        if($forupdate){
            header("Location: ./");
        }else{
            echo $twig->render("admin/updateSectionAdmin.html.twig",["contenu"=>$recupSection]);
        }

    }




}elseif (isset($_GET['addsection'])){

    /*
     *
     * On veut ajouter une section
     *
     */

    // si on a pas cliqué "envoyé" sur le formulaire
    if(empty($_POST)){


        // appel de la vue
        echo $twig->render("admin/ajoutSectionAdmin.html.twig");

    }else{

        // on crée une instance de thesection avec le formulaire POST en paramètre
        $insert = new thesection($_POST);

        // on appel le manager et on utilise la méthode d'insertion (true en cas de réussite et false en cas d'échec)

        $forinsert = $thesectionM->createSectionAdmin($insert);

        // si l'insertion est réussie
        if($forinsert){
            header("Location: ./");
        }else{

            // appel de la vue avec affichage d'une erreur
            echo $twig->render("admin/ajoutSectionAdmin.html.twig",["error"=>"Erreur lors de l'insertion, veuillez recommencer"]);

        }

    }



} else {

    /*
     *
     * Accueil de l'admin
     *
     */

// on appelle la vue générée par twig

    // on va chercher les sections et leurs étudiants (si il y en a)
    $recup = $thesectionM->selectionnerSectionIndexAdmin();
    echo $twig->render('admin/accueilAdmin.html.twig', ["section"=>$recup]);

}
  