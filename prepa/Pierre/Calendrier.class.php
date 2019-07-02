<?php

include_once 'DbConfig.class.php';
include_once 'CaseHoraire.class.php';
include_once 'Planning.class.php';

class Calendrier {
    private $planningSession;

    function __construct(Planning $lePlanning) {
        $this->planningSession = $lePlanning;
    }

    public function afficheTousLesMois(bool $seulementCeMois) {
        $debut = $this->planningSession->debut();
        $fin = $this->planningSession->fin();
        $fin = $fin->modify( '+1 day' );
        $intervalle = new DateInterval('P1M');

        $lesDates = new DatePeriod($debut, $intervalle ,$fin);

        foreach($lesDates as $date){
            $this->afficheMois($date->format("n"), $date->format("Y"), $seulementCeMois);
        }
    }

    public function afficheMois(int $mois, int $annee, bool $seulementCeMois) {
        // Recherche le nom du mois à partir du numéro du mois
        $nomMois = $this->convertirNumeroMoisVersNomMois($mois);

        // Recherche du premier et du dernier jour du mois
        $dateMinimale = new DateTime('first day of '.$nomMois.$annee);
        $dateMaximale = new DateTime('last day of '.$nomMois.$annee);

        if ($dateMinimale < $this->planningSession->debut()) {
            if ($dateMaximale < $this->planningSession->debut()) {
                echo "<h2>Ce calendrier (".$mois."-".$annee.") ne peut pas être calculé. Il est avant la session.</h2>";
            } else {
                // Le calendrier n'est pas entièrement compris dans la session. Il manque le début, on remplit avec les dates manquantes
                $this->planningSession->remplirListeDates(TRUE);

                $liste = $this->planningSession->extraireCalendrier($mois, $annee);

                $this->afficheGrille($liste, $mois, $annee, $seulementCeMois);
                }
        } elseif ($dateMaximale > $this->planningSession->fin()) {
            if ($dateMinimale > $this->planningSession->fin()){
                echo "<h2>Ce calendrier (".$mois."-".$annee.") ne peut pas être calculé. Il est après la session.</h2>";
            } else {
                // Le calendrier n'est pas entièrement compris dans la session. Il manque la fin, on remplit avec les dates manquantes
                $this->planningSession->remplirListeDates(FALSE);

                $liste = $this->planningSession->extraireCalendrier($mois, $annee);

                $this->afficheGrille($liste, $mois, $annee, $seulementCeMois);
                }
        } else {
            $liste = $this->planningSession->extraireCalendrier($mois, $annee);
            $this->afficheGrille($liste, $mois, $annee, $seulementCeMois);
        }
    }

    public function afficheGrille(array $liste, int $mois, int $annee, bool $seulementCeMois){
        //$clesListe = array_keys($liste);
        $grille = array_chunk($liste,7,TRUE);
        $lesMois = array('','Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre');
        $lesJours = array("","LUN","MAR","MER","JEU","VEN","SAM","DIM");

        echo "<h2>Calendrier</h2>";
        echo '<table class="calendrier" border="1">';
        echo '<tr><th colspan="7">'.$lesMois[$mois].' '.$annee.'</th></tr>';
        echo "<tr>";
        for ($i=1;$i<=7;$i++){
            echo "<th>".$lesJours[$i]."</th>";
        }
        echo "</tr>";

        for ($ligne=0;$ligne<count($grille);$ligne++){
            echo "<tr>";
            foreach($grille[$ligne] as $cle=>$valeur){
                $classeMatin = $valeur['AM']->type();
                $classeApresMidi = $valeur['PM']->type();
                $classeCSS = "AM".$classeMatin."PM".$classeApresMidi;

                if ( ($seulementCeMois==TRUE) && ( ($valeur['AM']->date()->format("m")!=$mois) || ($valeur['AM']->type()==CF2M_CASE_INCONNU) ) ) {
                    echo "<td id='".$cle."'></td>";
                } else {
                    echo "<td id='".$cle."' class='".$classeCSS."'>".$valeur['AM']->date()->format("d")."</td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    /* ------------------ Méthode à sortir pour la partager ------------------ */
    public function convertirNumeroMoisVersNomMois(int $numero): string {
        $uneDate = DateTime::createFromFormat('m', $numero);
        $nomMois = $uneDate->format('F');

        return $nomMois;
    }
    /* ----------------------------------------------------------------------- */
}
