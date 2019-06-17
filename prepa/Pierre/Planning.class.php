<?php 

class Planning 
{
    private $premiereDate;
    private $derniereDate;
    
    private $unjour;
    
    private $lesMois = array("0","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

    private $listeDates = array();

    function __construct()
    {
        $ctp = func_num_args();
        $args = func_get_args();
        switch($ctp)
        {
            case 0:
                $this->construct0();
                break;
            case 1:
                $this->construct1($args[0]);
                break;
            case 2:
                $this->construct2($args[0],$args[1]);
                break;
/*            case 3:
                $this->construct3($args[0],$args[1],$args[2]);
                break;*/
            default:
                echo "Erreur : nombre d'arguments incorrect dans le constructeur de la classe Planning.";
                exit();
                break;
        }
    }    

    function construct0() {
        $this->premiereDate = new DateTime(date('Y-m-d'));
        $this->derniereDate = new DateTime(date('Y-m-d'));
        $this->unjour = new DateInterval('P1D');
    }

    function construct1($sessID) {
        // on charge un objet Session grâce à son ID
        //print_r($sessID);

        // on récupère la date de début et la date de fin d'une session de formation
        $debutSession = '2018-11-07';
        $finSession = '2020-07-08';
        $this->premiereDate = new DateTime(date($debutSession));
        $this->derniereDate = new DateTime(date($finSession));
        $this->unjour = new DateInterval('P1D');

        // on construit le tableau avec toutes les dates possibles
        $tabcle = array();
        $tabcle = $this->calculToutesLesDates();
        //print_r($tabcle);

        $cours = array("coursAM"=>"?","coursPM"=>"?");
        $listeDates = array_fill_keys($tabcle, $cours);
        //print_r($listeDates);

        // on détecte les week-ends
        foreach($listeDates as $cle=>$valeur){
            if ($this->isWeekend(new DateTime($cle))) {
                //echo $cle." est un jour de weekend"."<br/>";
                $listeDates[$cle] = "WE";
            } else {
                //echo $cle." est un jour de cours"."<br/>";         
            }
        }
        //print_r($listeDates);

        // on recherche les jours fériés et les congés extra-légaux pour toutes les années concernées par la session
        $anneeDebut = (integer)substr($debutSession,0,4);
        $anneeFin = (integer)substr($finSession,0,4);

        for ($a = $anneeDebut; $a<=$anneeFin; $a++){
            // recherche des jours fériés
            $tab1 = array();
            $feries = $this->calculJoursFeries($a);

            foreach($feries as $date) {
                if (($date >= $this->premiereDate) && ($date <= $this->derniereDate))
                {
                    array_push($tab1, $date->format("Y-m-d"));
                }
            }
            $listeFeries = array_fill_keys($tab1, "Ferie");

            // recherche des congés extra-légaux du CF2M
            $tab2 = array();
            $extra = $this->calculExtraLegalCF2M($a);

            foreach($extra as $date) {
                if (($date >= $this->premiereDate) && ($date <= $this->derniereDate))
                {
                    array_push($tab2, $date->format("Y-m-d"));
                }
            }
            $listeExtra = array_fill_keys($tab2, "Extra");

            $listeDates = array_merge($listeDates,$listeFeries);
            $listeDates = array_merge($listeDates,$listeExtra);

            // recherche des autres congés du CF2M pour la session
            }

        // Affichage de la liste complète des dates pour la session
        foreach($listeDates as $cle=>$valeur){
            if (gettype($valeur)=="array"){
                echo $cle."</br>";
            } else {
                echo $cle." contient ".$valeur."</br>";
            }

        //print_r($listeDates);
        }
    }

    function construct2(string $debut, string $fin) {
        $this->premiereDate = new DateTime($debut);
        $this->derniereDate = new DateTime($fin);
        $this->unjour = new DateInterval('P1D');
    }

    public function getPremiereDate() {
        return $this->premiereDate->format('d-m-Y');
    }

    public function getDerniereDate() {
        return $this->derniereDate->format('d-m-Y');
    }

    public function isWeekend($unedate) {
        if ((date_format($unedate,'w')==0)||(date_format($unedate,'w')==6)){
            return true;
        } else {
            return false;
        }
    }

    public function calculToutesLesDates() {
        $periode = new DatePeriod($this->premiereDate, $this->unjour, $this->derniereDate->add(new DateInterval('P1D')));
        $tabDates = array();

        foreach ($periode as $date) {
            array_push($tabDates,$date->format('Y-m-d'));
        }    

        return $tabDates;
    }

    public function afficheToutesLesDates() {
        $periode = new DatePeriod($this->premiereDate, $this->unjour, $this->derniereDate->add(new DateInterval('P1D')));

        foreach ($periode as $date) {
            echo "<p>".$date->format('D d-m-Y')."</p>";
        }
    }

    public function cherchePremierJourDuMois($mois,$annee) {
        if (($mois>0)&&($mois<=12)) {
            $lemois = $this->lesMois[$mois];
        } else {
            echo "Erreur : valeur non autorisée";
        }
        $uneDate = new DateTime("first day of ".$lemois." ".$annee);
        
        return $uneDate->format('Y-m-d');
    }

    public function chercheDernierJourDuMois($mois,$annee) {
        if (($mois>0)&&($mois<=12)) {
            $lemois = $this->lesMois[$mois];
        } else {
            echo "Erreur : valeur non autorisée";
        }
        $uneDate = new DateTime("last day of ".$lemois." ".$annee);
        
        return $uneDate->format('Y-m-d');
    }

    public function cherchePremierLundiDuMois($mois,$annee) {
        if (($mois>0)&&($mois<=12)) {
            $lemois = $this->lesMois[$mois];
        } else {
            echo "Erreur : valeur non autorisée";
        }
        $uneDate = new DateTime("first mon of ".$lemois." ".$annee);
        
        return $uneDate->format('Y-m-d');
    }

    public function chercheDernierLundiDuMois($mois,$annee) {
        if (($mois>0)&&($mois<=12)) {
            $lemois = $this->lesMois[$mois];
        } else {
            echo "Erreur : valeur non autorisée";
        }
        $uneDate = new DateTime("last mon of ".$lemois." ".$annee);
        
        return $uneDate->format('Y-m-d');
    }


    public function afficheDatesPourUnMois($mois,$annee) {
        $debut = new DateTime($this->cherchePremierJourDuMois($mois,$annee));
        $fin = new DateTime($this->cherchePremierJourDuMois(($mois+1)%12,$annee));

        $periode = new DatePeriod($debut, $this->unjour, $fin);

        foreach ($periode as $date) {
            echo "<p>".$date->format('d-m-Y')."</p>";
        }
    }

    public function afficheTousLesJoursOuvrés() {
        $periode = new DatePeriod($this->premiereDate, $this->unjour, $this->derniereDate);

        foreach ($periode as $date) {
            if (!$this->isWeekend($date)){
                echo "<p>".$date->format('D d-m-Y')."</p>";
            }
        }
    }

    public function afficheJoursOuvrésPourUnMois($mois,$annee) {
        $debut = new DateTime($this->cherchePremierJourDuMois($mois,$annee));
        $fin = new DateTime($this->cherchePremierJourDuMois(($mois+1)%12,$annee));

        $periode = new DatePeriod($debut, $this->unjour, $fin);

        foreach ($periode as $date) {
            if (!$this->isWeekend($date)){
                echo "<p>".$date->format('D d-m-Y')."</p>";
            }
        }
    }

    public function afficheJoursOuvrésEntreDeuxDates($date1,$date2) {
        $debut = new DateTime($date1);
        $fin = new DateTime($date2);

        if ($fin>=$debut) {
            $periode = new DatePeriod($debut, $this->unjour, $fin);
        }

        foreach ($periode as $date) {
            if (!$this->isWeekend($date)){
                echo "<p>".$date->format('D d-m-Y')."</p>";
            }
        }
    }

    public function chercheLundisEntreDeuxDates($date1,$date2) {
        $debut = new DateTime($date1);
        $fin = new DateTime($date2);
        $lundis = array();

        if ($fin>=$debut) {
            $periode = new DatePeriod($debut, $this->unjour, $fin);
        }

        foreach ($periode as $date) {
            if (date_format($date,'w')==1) {
                $lundis[] = $date;
            }
        }

        //print_r($lundis);

        return $lundis;
    }

    public function listeCoursMois($mois,$annee){
        // recherche du premier jour du mois
        $premierJour = $this->cherchePremierJourDuMois($mois,$annee);
        // recherche du premier lundi du mois
        $premierLundi = $this->cherchePremierLundiDuMois($mois, $annee);
        // recherche du dernier lundi du mois
        $dernierLundi = $this->chercheDernierLundiDuMois($mois, $annee);
        // recherche du dernier lundi du mois
        $dernierJour = $this->chercheDernierJourDuMois($mois, $annee);

        $listeLundis = array();
        

/*        print_r($premierJour);
        print_r($premierLundi);
        print_r($dernierLundi);
        print_r($dernierJour);*/

        // si le premier jour du mois est avant le premier lundi, il faut rechercher le dernier lundi du mois précédent
        // pour connaître les dates de la semaine avant ce premier lundi
        if ($premierJour<$premierLundi) {
            $dernierLundiMoisPrecedent = new DateTime($premierLundi);
            $dernierLundiMoisPrecedent = $dernierLundiMoisPrecedent->modify('previous week');
            $dernierLundiMoisPrecedent = $dernierLundiMoisPrecedent->format('Y-m-d');

            $listeLundis = $this->chercheLundisEntreDeuxDates($dernierLundiMoisPrecedent,$dernierJour);
        } else {
            $listeLundis = $this->chercheLundisEntreDeuxDates($premierLundi,$dernierJour);
        }

        //print_r($listeLundis);

        foreach($listeLundis as $lundi) {
            $uneSemaine = $this->listeCoursSemaine($lundi->format('Y-m-d'), '09:00:00', '13:00:00', 'PT3H30M');
            $this->afficheListeCours($uneSemaine);
        }
    }

    public function listeCoursSemaine($dateLundi, $debutMatin, $debutApresMidi, $dureeCours) {
        // Exemple :
        // $dateLundi = 2019-06-03
        // $debutMatin = 09:00:00
        // $debutApresMidi = 13:00:00
        // $dureeCours = PT3H30M (3h30min)
        $lundiAM = new DateTime($dateLundi.'T'.$debutMatin);    // début du cours du matin
        $lundiPM = new DateTime($dateLundi.'T'.$debutApresMidi);// début du cours de l'après-midi
        $intervalle = new DateInterval("P1D");                  // intervalle entre chaque jour de cours
        $duree = new DateInterval($dureeCours);                 // durée d'un cours
        $periodes = array();                                    // tableau de toutes les périodes de cours

        $matins = new DatePeriod($lundiAM, $intervalle, 4);         // tous les matins
        $apresmidis = new DatePeriod($lundiPM, $intervalle, 4);     // tous les après-midis

        $i=0;
        foreach ($matins as $date) {
            // début du cours du matin
            $periodes[$i][0] = $date->format('d-m-Y H:i:s');
            $date->add($duree);
            // fin du cours du matin
            $periodes[$i][1] = $date->format('d-m-Y H:i:s');
            // on passe au jour suivant
            $i++;
        }

        $i=0;
        foreach ($apresmidis as $date) {
            // début du cours de l'après-midi
            $periodes[$i][2] = $date->format('d-m-Y H:i:s');
            $date->add($duree);
            // fin du cours de l'après-midi
            $periodes[$i][3] = $date->format('d-m-Y H:i:s');
            // on passe au jour suivant
            $i++;
        }

        return $periodes;
    }

    public function afficheListeCours($tab) {
        echo "<ul>";
        for ($jour=0;$jour<5;$jour++) {
            $ligne= "<li>";
            for ($moment=0;$moment<=3;$moment++) {
                $ligne.=$tab[$jour][$moment]." | ";
            }
            $ligne.="</li>";
            echo $ligne;
        }
        echo "</ul>";
    }

    public function calculJoursFeries(int $annee) {
        $listeFeries = array();
        $uneDate;

        // Jours fixes
        $uneDate = new DateTime('first day of january '.$annee);    // jour de l'an - 1er janvier
        array_push($listeFeries, $uneDate);     
        $uneDate = new DateTime('first day of may '.$annee);    // Fete du travail - 1er mai
        array_push($listeFeries, $uneDate);         
        $uneDate = new DateTime('first day of july '.$annee); $uneDate = $uneDate->add(new DateInterval('P20D'));   // Fête nationale belge - 21 juillet
        array_push($listeFeries, $uneDate);
        $uneDate = new DateTime('first day of august '.$annee); $uneDate = $uneDate->add(new DateInterval('P14D'));   // Assomption - 15 août
        array_push($listeFeries, $uneDate);
        $uneDate = new DateTime('first day of november '.$annee);    // Toussaint - 1er novembre
        array_push($listeFeries, $uneDate);         
        $uneDate = new DateTime('first day of november '.$annee); $uneDate = $uneDate->add(new DateInterval('P10D'));   // Armistice - 11 novembre
        array_push($listeFeries, $uneDate);
        $uneDate = new DateTime('first day of december '.$annee); $uneDate = $uneDate->add(new DateInterval('P24D'));   // Noel - 25 décembre
        array_push($listeFeries, $uneDate);

        // Jours variables
        $dimanchePaques = easter_date($annee);  // renvoie le timestamp du Dimanche de Pâques

        $paques = new DateTime(); $paques->setTimestamp($dimanchePaques); $paques->setTimezone(new DateTimeZone('Europe/Brussels'));   // conversion en objet DateTime
        $paques->add(new DateInterval('P1D'));      // Lundi de Pâques (Pâques + 1 jour)
        array_push($listeFeries, $paques);

        $ascension = new DateTime(); $ascension->setTimestamp($dimanchePaques); $ascension->setTimezone(new DateTimeZone('Europe/Brussels'));   // conversion en objet DateTime
        $ascension->add(new DateInterval('P39D'));  // Jeudi Ascension (Pâques + 39 jours)
        array_push($listeFeries, $ascension);

        $pentecote = new DateTime(); $pentecote->setTimestamp($dimanchePaques); $pentecote->setTimezone(new DateTimeZone('Europe/Brussels'));   // conversion en objet DateTime
        $pentecote->add(new DateInterval('P50D'));  // Jeudi Ascension (Pâques + 50 jours)
        array_push($listeFeries, $pentecote);

        // Renvoi de la liste
        return $listeFeries;
    }

    public function calculExtraLegalCF2M(int $annee) {
        $extraLegalCF2M = array();
        $uneDate;

        // Jours fixes
        $uneDate = new DateTime('first day of january '.$annee); $uneDate = $uneDate->add(new DateInterval('P1D'));    // 2ème jour de l'an - 2 janvier
        array_push($extraLegalCF2M, $uneDate);     
        $uneDate = new DateTime('first day of september '.$annee); $uneDate = $uneDate->add(new DateInterval('P26D'));   // Fête FWB - 27 septembre
        array_push($extraLegalCF2M, $uneDate);
        $uneDate = new DateTime('first day of november '.$annee); $uneDate = $uneDate->add(new DateInterval('P1D'));    // Jour des Morts - 2 novembre
        array_push($extraLegalCF2M, $uneDate);         
        $uneDate = new DateTime('first day of december '.$annee); $uneDate = $uneDate->add(new DateInterval('P25D'));   // Lendemain de Noel - 26 décembre
        array_push($extraLegalCF2M, $uneDate);

        // Renvoi de la liste
        return $extraLegalCF2M;
    }

}

?>