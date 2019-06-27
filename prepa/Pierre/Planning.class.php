<?php

include_once 'DbConfig.class.php';
include_once 'CaseHoraire.class.php';

class Planning 
{
    private $premiereDate;
    private $derniereDate;
    private $unjour;
    
    private $listeDates = array();

    function __construct(int $sessID)
    {
        // on charge un objet Session grâce à son ID
//        print_r($sessID);

        // on récupère la date de début et la date de fin d'une session de formation, ici exemple pour tester
        $debutSession = '2018-11-07';
        $finSession = '2020-05-08';

        $this->premiereDate = new DateTime(date($debutSession));
        $this->derniereDate = new DateTime(date($finSession));
        $this->unjour = new DateInterval('P1D');

        $this->calculPlanning();

//        $this->afficheTableau("Liste complète",$this->listeDates);
        return $this->listeDates;
    }

    public function calculPlanning(){
        $debutSession = $this->premiereDate->format('Y-m-d');
        $finSession = $this->derniereDate->format('Y-m-d');

        // on construit le tableau avec toutes les dates possibles
        $tabcle = array();
        $tabcle = $this->calculToutesLesDates();

        foreach($tabcle as $cle=>$valeur){
            $unCours = $this->creerJour(new DateTime($valeur), CF2M_CASE_COURS, CF2M_CASE_COURS);
            $this->listeDates[$valeur] = $unCours;
        }
        //$this->afficheTableau("Liste des jours", $this->listeDates);

        // on recherche les jours fériés et les congés extra-légaux pour toutes les années concernées par la session
        $anneeDebut = (integer)substr($debutSession,0,4);
        $anneeFin = (integer)substr($finSession,0,4);

        for ($a = $anneeDebut; $a<=$anneeFin; $a++){
            // ------------------ recherche des jours fériés ---------------------------
            $feries = $this->calculJoursFeries($a);

            foreach($feries as $ferie) {
                if (($ferie['AM']->date() >= $this->premiereDate) && ($ferie['AM']->date() <= $this->derniereDate))
                {
                    $listeFeries[$ferie['AM']->date()->format("Y-m-d")] = $ferie;
                }
            }

            // ------------------- recherche des congés extra-légaux du CF2M ----------------
            $extras = $this->calculExtraLegalCF2M($a);

            foreach($extras as $extra) {
                if (($extra['AM']->date() >= $this->premiereDate) && ($extra['AM']->date() <= $this->derniereDate))
                {
                    $listeExtra[$extra['AM']->date()->format("Y-m-d")] = $extra;
                }
            }
        }
//        $this->afficheTableau("Liste des fériés",$listeFeries);
//        $this->afficheTableau("Liste des jours extra-légaux",$listeExtra);

        // ---------------- recherche des autres congés du CF2M pour la session ----------------
        $conges = $this->calculConges(123);

        foreach($conges as $conge) {
            if (($conge['AM']->date() >= $this->premiereDate) && ($conge['AM']->date() <= $this->derniereDate))
            {
                $listeConges[$conge['AM']->date()->format("Y-m-d")] = $conge;
            }
        }
//        $this->afficheTableau("Liste des congés",$listeConges);

        // fusion des tableaux
        $this->listeDates = array_merge($this->listeDates, $listeConges);

        // on détecte les week-ends
        foreach($this->listeDates as $cle=>$valeur){
            $uneDate = new DateTime($cle);
            if ($this->isWeekend($uneDate)) {
                //echo $cle." est un jour de weekend"."<br/>";
                $this->listeDates[$cle] = $this->creerJour($uneDate, CF2M_CASE_WEEKEND, CF2M_CASE_WEEKEND);
            }
        }

        // fusion des tableaux
        $this->listeDates = array_merge($this->listeDates,$listeFeries);
        $this->listeDates = array_merge($this->listeDates,$listeExtra);
    }

    public function debut():DateTime {
        return $this->premiereDate;
    }

    public function fin():DateTime {
        return $this->derniereDate;
    }

    public function liste(): array {
        return $this->listeDates;
    }

    public function extraireListeEntreDeuxDates(string $date1, string $date2): array {
        $listePartielle = array();

        $d1 = new DateTime($date1);
        $d2 = new DateTime($date2);

        if ($d1<=$d2) {
            $debut = $d1;   $fin = $d2;
        } else {
            $debut = $d2;   $fin = $d1;
        }

        foreach($this->listeDates as $cle=>$valeur){
            $dateTest = new DateTime($cle);
            if (($dateTest>=$debut)&&($dateTest<=$fin)) {
                $listePartielle[$cle] = $valeur;
            }                
        }

        return $listePartielle;
    }

    /* ------------------ Méthode à sortir pour la partager ------------------ */
    public function convertirNumeroMoisVersNomMois(int $numero): string {
        $uneDate = DateTime::createFromFormat('m', $numero);
        $nomMois = $uneDate->format('F');

        return $nomMois;
    }
    /* ----------------------------------------------------------------------- */

    public function extraireCetteSemaine(): array {
        $premierJour = new DateTime('Monday this week');
        $dernierJour = new DateTime('Friday this week');

        $liste = $this->extraireListeEntreDeuxDates($premierJour->format("Y-m-d"), $dernierJour->format("Y-m-d"));
        $this->afficheListe($liste);
        return $liste;
    }

    public function extraireSemaineProchaine(): array {
        $premierJour = new DateTime('Monday next week');
        $dernierJour = new DateTime('Friday next week');

        $liste = $this->extraireListeEntreDeuxDates($premierJour->format("Y-m-d"), $dernierJour->format("Y-m-d"));
        $this->afficheListe($liste);
        return $liste;
    }

    public function extraireListeMois(int $mois,int $annee): array {
        $nomMois = $this->convertirNumeroMoisVersNomMois($mois);

        $premierJour = new DateTime('first day of '.$nomMois.$annee);
        $dernierJour = new DateTime('last day of '.$nomMois.$annee);

        $liste = $this->extraireListeEntreDeuxDates($premierJour->format("Y-m-d"), $dernierJour->format("Y-m-d"));
        return $liste;
    }

    public function extraireCalendrier($mois, $annee): array {
        // Recherche le nom du mois à partir du numéro du mois
        $nomMois = $this->convertirNumeroMoisVersNomMois($mois);

        // Recherche du premier et du dernier jour du mois
        $premierJour = new DateTime('first day of '.$nomMois.$annee);
        $dernierJour = new DateTime('last day of '.$nomMois.$annee);

        // Si le 1er jour du mois n'est pas un lundi, on cherche le lundi précédent
        if (date_format($premierJour,'w') != 1) {
            if ($mois==1){
                $moisPrecedent = $this->convertirNumeroMoisVersNomMois(12);
                $premiereDate = new DateTime('last monday of '.$moisPrecedent.($annee-1));
            } else {
                $moisPrecedent = $this->convertirNumeroMoisVersNomMois($mois-1);
                $premiereDate = new DateTime('last monday of '.$moisPrecedent.$annee);
            }
        } else {
            $premiereDate = $premierJour;
        }

        // Si le dernier jour du mois n'est pas un dimanche, on cherche le dimanche suivant
        if (date_format($dernierJour,'w') != 0) {
            if ($mois==12) {
                $moisSuivant = $this->convertirNumeroMoisVersNomMois(1);
                $derniereDate = new DateTime('first sunday of '.$moisSuivant.($annee+1));
            } else {
                $moisSuivant = $this->convertirNumeroMoisVersNomMois($mois+1);
                $derniereDate = new DateTime('first sunday of '.$moisSuivant.$annee);
            }
        } else {
            $derniereDate = $dernierJour;
        }

        $joursMois = $this->extraireListeEntreDeuxDates($premiereDate->format("Y-m-d"), $derniereDate->format("Y-m-d"));
//        $this->afficheListe($joursMois);
        
        return $joursMois;
    }

    public function remplirListeDates(bool $avant) {
        $moisDebutSession = $this->premiereDate->format('n');
        $anneeDebutSession = $this->premiereDate->format('Y');
        $moisFinSession = $this->derniereDate->format('n');
        $anneeFinSession = $this->derniereDate->format('Y');

        if ($avant==TRUE){ // Compléter les dates AVANT le début de la session
            $nomMoisDebutSession = $this->convertirNumeroMoisVersNomMois($moisDebutSession);
            $premierJourMois = new DateTime('first day of '.$nomMoisDebutSession.$anneeDebutSession);
    
            // Si le 1er jour du mois n'est pas un lundi, on cherche le lundi précédent
            if (date_format($premierJourMois,'w') != 1) {
                if ($moisDebutSession==1){
                    $moisPrecedent = $this->convertirNumeroMoisVersNomMois(12);
                    $dateDebut = new DateTime('last monday of '.$moisPrecedent.($anneeDebutSession-1));
                } else {
                    $moisPrecedent = $this->convertirNumeroMoisVersNomMois($moisDebutSession-1);
                    $dateDebut = new DateTime('last monday of '.$moisPrecedent.$anneeDebutSession);
                }
            } else {
                $dateDebut = $premierJourMois;
            }

//            echo "La session va être prolongée au début, à partir du ".$dateDebut->format("Y-m-d")."<br/>";
            $aRemplirAvant = new DatePeriod($dateDebut, $this->unjour, $this->premiereDate);
            foreach($aRemplirAvant as $date){
                $unJourBlanc = $this->creerJour($date, CF2M_CASE_INCONNU, CF2M_CASE_INCONNU);
                $this->listeDates[$date->format("Y-m-d")] = $unJourBlanc;
            }
            ksort($this->listeDates);   // trier la liste des dates par ordre chronologique
        } 
        else 
        { // Compléter les dates après la fin de la session
            $nomMoisFinSession = $this->convertirNumeroMoisVersNomMois($moisFinSession);
            $dernierJourMois = new DateTime('last day of '.$nomMoisFinSession.$anneeFinSession);

            // Si le dernier jour du mois n'est pas un dimanche, on cherche le dimanche suivant
            if (date_format($dernierJourMois,'w') != 0) {
                if ($moisFinSession==12) {
                    $moisSuivant = $this->convertirNumeroMoisVersNomMois(1);
                    $dateFin = new DateTime('first sunday of '.$moisSuivant.($anneeFinSession+1));
                } else {
                    $moisSuivant = $this->convertirNumeroMoisVersNomMois($moisFinSession+1);
                    $dateFin = new DateTime('first sunday of '.$moisSuivant.$anneeFinSession);
                }
            } else {
                $dateFin = $dernierJourMois;
            }

//            echo "La session va être prolongée à la fin, jusqu'au ".$dateFin->format("Y-m-d")."<br/>";
            $aRemplirApres = new DatePeriod($this->derniereDate, $this->unjour, $dateFin->add(new DateInterval('P1D')));
            foreach($aRemplirApres as $date){
                $unJourBlanc = $this->creerJour($date, CF2M_CASE_INCONNU, CF2M_CASE_INCONNU);
                $this->listeDates[$date->format("Y-m-d")] = $unJourBlanc;
            }
            ksort($this->listeDates);   // trier la liste des dates par ordre chronologique
        }
    }

    private function afficheListe(array $liste) {
        // Affichage de la liste complète des dates pour la session
        foreach($liste as $cle=>$valeur){
            if (gettype($valeur)=="array"){
                $typeAM = $this->caseToString($valeur['AM']->type());
                $typePM = $this->caseToString($valeur['PM']->type());
                echo $cle." contient : ".$typeAM." | ".$typePM."</br>";
            } else {
                $typeDate = $this->caseToString(valeur);
                echo $cle." contient la valeur ".$typeDate."</br>";
            }
        }
    }

    private function afficheListeEntreDeuxDates(string $date1, string $date2) {
        $liste = $this->extraireListeEntreDeuxDates($date1, $date2);

        $this->afficheListe($liste);
    }

    private function afficheListeComplete() {
        $this->afficheListe($this->listeDates);
    }

    private function afficheTableau(string $titre, array $liste){
        echo "<h2>".$titre."</h2>";
        foreach($liste as $cle=>$valeur){
            echo "<p>".$cle." ==> Case AM : ".$valeur['AM']->date()->format('Y-m-d')." type ".$valeur['AM']->type()." ET Case PM : ".$valeur['AM']->date()->format('Y-m-d')." type ".$valeur['PM']->type()."</p>";
        }
        echo "<hr/>";
    }

    /* ------------------- Méthode à sortir -------------- ------------------ */
    private function caseToString(int $valeur) {
        switch($valeur){
            case CF2M_CASE_COURS : $typeDate = "Cours"; break;
            case CF2M_CASE_CONGE : $typeDate = "Congé"; break;
            case CF2M_CASE_FERIE : $typeDate = "Férié"; break;
            case CF2M_CASE_EXTRALEGAL : $typeDate = "Extra-légal"; break;
            case CF2M_CASE_WEEKEND : $typeDate = "Week-end"; break;
            case CF2M_CASE_INCONNU : $typeDate = "???"; break;
            default : $typeDate = "Erreur !";    
        }

        return $typeDate;
    }
    /* ----------------------------------------------------------------------- */

    private function isWeekend(DateTime $unedate) {
        if ((date_format($unedate,'w')==0)||(date_format($unedate,'w')==6)){
            return true;
        } else {
            return false;
        }
    }

    private function creerJour(DateTime $date,int $matin,int $apresmidi) {
        $jour = array("AM"=>new CaseHoraire($date, $matin),"PM"=>new CaseHoraire($date,$apresmidi));
        return $jour;
    }

    private function calculToutesLesDates() {
        $periode = new DatePeriod($this->premiereDate, $this->unjour, $this->derniereDate->add(new DateInterval('P1D')));
        $tabDates = array();

        foreach ($periode as $date) {
            array_push($tabDates,$date->format('Y-m-d'));
        }    

        return $tabDates;
    }

    private function calculJoursFeries(int $annee): array {
        $listeFeries = array();
        $uneDate;

        // Jours fixes
        $uneDate = new DateTime('first day of january '.$annee);    // jour de l'an - 1er janvier
        array_push($listeFeries, $this->creerJour($uneDate, CF2M_CASE_FERIE, CF2M_CASE_FERIE));

        $uneDate = new DateTime('first day of may '.$annee);    // Fete du travail - 1er mai
        array_push($listeFeries, $this->creerJour($uneDate, CF2M_CASE_FERIE, CF2M_CASE_FERIE));
        
        $uneDate = new DateTime('first day of july '.$annee); $uneDate = $uneDate->add(new DateInterval('P20D'));   // Fête nationale belge - 21 juillet
        array_push($listeFeries, $this->creerJour($uneDate, CF2M_CASE_FERIE, CF2M_CASE_FERIE));
        
        $uneDate = new DateTime('first day of august '.$annee); $uneDate = $uneDate->add(new DateInterval('P14D'));   // Assomption - 15 août
        array_push($listeFeries, $this->creerJour($uneDate, CF2M_CASE_FERIE, CF2M_CASE_FERIE));
        
        $uneDate = new DateTime('first day of november '.$annee);    // Toussaint - 1er novembre
        array_push($listeFeries, $this->creerJour($uneDate, CF2M_CASE_FERIE, CF2M_CASE_FERIE));
        
        $uneDate = new DateTime('first day of november '.$annee); $uneDate = $uneDate->add(new DateInterval('P10D'));   // Armistice - 11 novembre
        array_push($listeFeries, $this->creerJour($uneDate, CF2M_CASE_FERIE, CF2M_CASE_FERIE));
        
        $uneDate = new DateTime('first day of december '.$annee); $uneDate = $uneDate->add(new DateInterval('P24D'));   // Noel - 25 décembre
        array_push($listeFeries, $this->creerJour($uneDate, CF2M_CASE_FERIE, CF2M_CASE_FERIE));

        // Jours variables
        $dimanchePaques = easter_date($annee);  // renvoie le timestamp du Dimanche de Pâques

        $paques = new DateTime(); $paques->setTimestamp($dimanchePaques); $paques->setTimezone(new DateTimeZone('Europe/Brussels'));   // conversion en objet DateTime
        $paques->add(new DateInterval('P1D'));      // Lundi de Pâques (Pâques + 1 jour)
        array_push($listeFeries, $this->creerJour($paques, CF2M_CASE_FERIE, CF2M_CASE_FERIE));

        $ascension = new DateTime(); $ascension->setTimestamp($dimanchePaques); $ascension->setTimezone(new DateTimeZone('Europe/Brussels'));   // conversion en objet DateTime
        $ascension->add(new DateInterval('P39D'));  // Jeudi Ascension (Pâques + 39 jours)
        array_push($listeFeries, $this->creerJour($ascension, CF2M_CASE_FERIE, CF2M_CASE_FERIE));

        $pentecote = new DateTime(); $pentecote->setTimestamp($dimanchePaques); $pentecote->setTimezone(new DateTimeZone('Europe/Brussels'));   // conversion en objet DateTime
        $pentecote->add(new DateInterval('P50D'));  // Jeudi Ascension (Pâques + 50 jours)
        array_push($listeFeries, $this->creerJour($pentecote, CF2M_CASE_FERIE, CF2M_CASE_FERIE));

        // Renvoi de la liste
//        $this->afficheTableau("Liste des jours fériés", $listeFeries);
        return $listeFeries;
    }

    private function calculExtraLegalCF2M(int $annee): array {
        $extraLegalCF2M = array();
        $uneDate;

        // Jours fixes
        $uneDate = new DateTime('first day of january '.$annee); $uneDate = $uneDate->add(new DateInterval('P1D'));    // 2ème jour de l'an - 2 janvier
        array_push($extraLegalCF2M, $this->creerJour($uneDate, CF2M_CASE_EXTRALEGAL, CF2M_CASE_EXTRALEGAL));

        $uneDate = new DateTime('first day of september '.$annee); $uneDate = $uneDate->add(new DateInterval('P26D'));   // Fête FWB - 27 septembre
        array_push($extraLegalCF2M, $this->creerJour($uneDate, CF2M_CASE_EXTRALEGAL, CF2M_CASE_EXTRALEGAL));

        $uneDate = new DateTime('first day of november '.$annee); $uneDate = $uneDate->add(new DateInterval('P1D'));    // Jour des Morts - 2 novembre
        array_push($extraLegalCF2M, $this->creerJour($uneDate, CF2M_CASE_EXTRALEGAL, CF2M_CASE_EXTRALEGAL));

        $uneDate = new DateTime('first day of december '.$annee); $uneDate = $uneDate->add(new DateInterval('P25D'));   // Lendemain de Noel - 26 décembre
        array_push($extraLegalCF2M, $this->creerJour($uneDate, CF2M_CASE_EXTRALEGAL, CF2M_CASE_EXTRALEGAL));

        // Renvoi de la liste
//        $this->afficheTableau("Liste des congés extra-légaux", $extraLegalCF2M);
        return $extraLegalCF2M;
    }

    private function calculConges(int $sessionID): array {
        $conges = array();

        // connection à la DB
        $dbConn = new DbConfig();

        // récupérer les congés associés à cette session
        //echo "Congés associés à la session id=".$sessionID;
        $result = $dbConn->select("SELECT debut,fin,type FROM conges WHERE session_id=".$sessionID);
        
        foreach($result as $cle=>$valeur){
            $datedebut = $valeur['debut'];
            $datefin = $valeur['fin'];
            
            if ($datedebut==$datefin)
            { // un seul jour
                switch($valeur['type']){
                    case 1 : $caseConge = $this->creerJour(new DateTime($datedebut), CF2M_CASE_CONGE, CF2M_CASE_COURS);
                            array_push($conges, $caseConge); break;
                    case 2 : $caseConge = $this->creerJour(new DateTime($datedebut), CF2M_CASE_COURS, CF2M_CASE_CONGE);
                            array_push($conges, $caseConge); break;
                    case 3 : $caseConge = $this->creerJour(new DateTime($datedebut), CF2M_CASE_CONGE, CF2M_CASE_CONGE);
                            array_push($conges, $caseConge); break;
                    default: $caseConge = $this->creerJour(new DateTime($datedebut), CF2M_CASE_COURS, CF2M_CASE_COURS);
                            array_push($conges, $caseConge); break;
                }
            } else 
            { // plusieurs jours consécutifs
                $intervalle = new DateInterval("P1D");
                $listeJours = new DatePeriod(new DateTime($datedebut), $intervalle, new DateTime($datefin." + 1 day"));

                foreach($listeJours as $unedate){
                    $caseConge = $this->creerJour($unedate, CF2M_CASE_CONGE, CF2M_CASE_CONGE);
                    array_push($conges, $caseConge);
                }
            }
        }
        
        // Renvoi de la liste
//        $this->afficheTableau("Liste des autres congés", $conges);
        return $conges;
    }
}

?>