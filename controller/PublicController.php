<?php

// page d'accueil
if(!isset($_GET['connect'])){
    // lien vers la page d'accueil
    echo $twig->render("public/homepage.html.twig");
}
