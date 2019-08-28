
<?php

/*
 *
 * Contrôleur gérant les droits
 *
 * La variable get adminstudent doit être présente pour accèder à ce contrôleur (et on doit être connecté évidemment!)
 *
 *
 */


if (isset($_GET['addledroit'])) {

    /*
     * on veut ajouter un droit
     */

    // si le formulaire n'est pas envoyé
    if (empty($_POST)) {

        // on utilise la méthode qui prend titre et id de toutes les sections
        $recupSections = $ledroitM->creerMenu();

        // appel de la vue avec le passage des sections
        echo $twig->render("admin/ledroit/ajoutAdminLedroit.html.twig", ["ledroit" => $recupLedroit]);
    } else {

        // le formulaire est envoyé
        // on va instancier la classe ledroit pour hydrater lintitule et ladescription
        $student = new ledroit($_POST);

        // si on a au moins un droit
        if (isset($_POST['idledroit'])) {

            // insertion de l'étudiant et des sections 
            $insert = $ledroitM->insertLedroitWithSectionTransaction($student, $_POST['idledroit']);

            // on a pas de sections    
        } else {
            // insertion de l'étudiant
            $insert = $ledroitM->insertLedroitWithSectionTransaction($student);
        }

        if ($insert) {
            header("Location: ./?adminstudent");
        } else {
            //header("Location: ./?adminstudent&addstudent");
        }
    }
} elseif (isset($_GET['update']) && ctype_digit($_GET['update'])) {
    
    
    $idstagiaire = (int) $_GET['update'];
    
    
    /*
     * on veut modifier un stagiaire
     */
    
    // affichage du formulaire
    if(empty($_POST)){
        
        // on récupère l'étudiant grâce à son ID
        // Et l'id des sections pour cocher les sections dans lesquelles l'étudiant se trouve avant l'update
        $recupStudent = $ledroittM->selectionnerStudentById($idstagiaire);
        
        // on utilise la méthode qui prend titre et id de toutes les sections 
        // pour afficher toutes les sections possibles pour l'update du stagiaire
        $recupSections = $ledroitM->creerMenu();
        
        // appel de la vue
        echo $twig->render("admin/student/updateAdminStudent.html.twig",["sections"=>$recupSections,"student"=>$recupStudent]);
    
    // si le formulaire est envoyé    
    }else{
        
        // var_dump($_POST);
        
        // instanciation de ledroitt avec la variable POST (pour utiliser les setters de vérification de données)
        $updateStudent = new ledroitt($_POST);
        
        // var_dump($updateStudent);
        
        // si on a coché (ou laissé coché) au moins une section, on remplit $section grâce à une condition ternaire
        $sections = (isset($_POST['idledroit']))? $_POST['idledroit']: [];
        
        // on appel la fonction qui effectue l'update d'un student (et qui supprime/ ajoute les sections pour cet étudiant) => argument (ledroitt, array, int)
        
        $update = $ledroittM->updateStudentByIdWithSections($updateStudent,$sections,$idstagiaire);
        
        
    }
    
       
    
    
} elseif (isset($_GET['delete']) && ctype_digit($_GET['delete'])) {
    /*
     * on veut supprimer un stagiaire
     */
    $idstagiaire = (int) $_GET['delete'];

    // si on a pas validé la suppression
    if (!isset($_GET['ok'])) {

        // on récupère l'étudiant grâce à son ID
        $recupStudent = $ledroittM->selectionnerStudentById($idstagiaire);
        
        // appel de la vue avec le passage d'un étudiant
        echo $twig->render("admin/student/deleteAdminStudent.html.twig",array("user"=>$recupStudent));
        
        
    // on a validé la suppression (existance de la variable get "ok")    
    }else{
        
        // suppression (pas de retour avec void: deleteStudentById(int $id):void{...} )
        $ledroittM->deleteStudentById($idstagiaire);
        
        header("Location: ./?adminstudent");
        exit();
        
    }
} else {

    /*
     * Page d'accueil
     */

// récupérer tous les stagiaires avec les sections dans lesquelles ils sont, affichez les stagiaires qui n'ont pas de section également
    $recupStudents = $ledroittM->selectionnerAllStudent();


    // appel de la vue avec le passage des étudiants
    echo $twig->render("admin/student/accueilAdminStudent.html.twig", ["student" => $recupStudents]);
}