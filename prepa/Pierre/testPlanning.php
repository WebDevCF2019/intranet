<?php
    require("Planning.class.php");
    //require("Conge.class.php");

    //$unPlanning = new Planning();
    //$unPlanning = new Planning('2019-01-07','2019-07-05');
    $unPlanning = new Planning(123);
    //$unConge = new Conge(123);

    echo "<h1>Planning</h1>";

    //echo "<h2>Tous les jours ouvrables du planning (entre le ".$unPlanning->getPremiereDate()." et le ".$unPlanning->getDerniereDate().") :</h2>";
    //$unPlanning->afficheToutesLesDates();
    //$unPlanning->afficheTousLesJoursOuvrés();

    //echo "<h2>Jours ouvrables de avril 2019 :</h2>";
    //$unPlanning->afficheDatesPourUnMois(6,2019);
    //$unPlanning->afficheJoursOuvrésPourUnMois(4,2019);

    //echo "<h2>Jours ouvrables entre 2 dates (par exemple, entre le 1er juin et le 15 juin 2019) :</h2>";
    //$unPlanning->afficheJoursOuvrésEntreDeuxDates('2019-06-01','2019-06-15');

    //echo "<h2>Cours de la semaine :</h2>";
    //$cetteSemaine = $unPlanning->listeCoursSemaine('2019-06-03', '09:00:00', '13:00:00', 'PT3H30M');
    //$unPlanning->afficheListeCours($cetteSemaine);

    //echo "<h2>Cours du mois (exemple : janvier 2019) :</h2>";
    //$unPlanning->listeCoursMois(6,2019);

    //echo "<h2>Jours Fériés (exemple : 2019) :</h2>";
    //print_r($unPlanning->calculJoursFeries(2019));

    //echo "<h2>Congés Extra-légaux CF2M (exemple : 2019) :</h2>";
    //print_r($unPlanning->calculExtraLegalCF2M(2019));

?>