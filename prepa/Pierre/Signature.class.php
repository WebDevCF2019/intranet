<?php
require('fpdf.php');

define("LARGEUR_COLONNE", 24);

class feuilleSignature extends FPDF {

    private $infosSemaine = array();

    public function __construct(array $semaine){
        parent::__construct('L', 'mm', 'A4');

        $this->SetAutoPageBreak(FALSE);
        $this->SetMargins(0,0,0);

        $this->infosSemaine = $semaine;
    }

    public function picto(string $nomFichier) {
        $this->Image($nomFichier,12,4,24,24);
    }

    public function entete(string $groupe){
        // Affichage du nom du groupe
        $this->SetXY(50,10);
        $this->SetFont("Arial","B",16);
        $this->Cell(60,5,$groupe,0,0,"L");

        // affichage de la semaine
        $texteEntete = "Semaine du ".$this->infosSemaine[0]["date"]->format("d/m/Y")." au ".$this->infosSemaine[4]["date"]->format("d/m/Y");
        $this->Cell(100, 5, $texteEntete, 0, 0, "C");

        // affichage des 5 jours
        $this->SetXY(40,20);
        $this->SetFont("Arial","",10);

        $nomJour=array("lundi","mardi","mercredi","jeudi","vendredi");
        for ($j=0;$j<5;$j++){
            $this->Cell(2*LARGEUR_COLONNE,5,$nomJour[$j].$this->infosSemaine[$j]["date"]->format(" d"),1,0,"C");
        }

        // affichage des "matin" et "après-midi"
        $this->SetXY(40,25);
        $this->SetFont("Arial","",10);

        for ($j=0;$j<5;$j++){
            $this->Cell(LARGEUR_COLONNE,5,"matin",1,0,"C");
            $this->Cell(LARGEUR_COLONNE,5,utf8_decode("après-midi"),1,0,"C");
        }
    }

    public function listeStagiaires(array $liste){

        $ligne=0;

        // Affichage d'une ligne par stagiaire
        foreach($liste as $personne){
            $this->SetFillColor(192,192,192);

            // affichage du nom du stagiaire
            $nom = explode("|",$personne);  // séparation nom prénom

            if ($this->GetStringWidth($personne)>28){   // affichage sur 2 lignes si le nom est trop grand
                $this->SetXY(10,30+(16*$ligne));
                $this->Cell(30,8,utf8_decode($nom[0]),"LRT",0,"C");
                $this->SetXY(10,38+(16*$ligne));
                $this->Cell(30,8,utf8_decode($nom[1]),"LRB",0,"C");
            } else {
                $this->SetXY(10,30+(16*$ligne));
                $this->Cell(30,16,utf8_decode($nom[0]." ".$nom[1]),1,0,"C");
            }

            // affichage des cases pour signer
            $this->SetXY(40,30+(16*$ligne));
            for ($j=0;$j<5;$j++){       
                if ($this->infosSemaine[$j]['AM'] != 0) {    // matin
                    $this->Cell(LARGEUR_COLONNE,12,"",1,0,"C", TRUE);   // congé
                } else {
                    $this->Cell(LARGEUR_COLONNE,12,"",1,0,"L");         // cours
                }
                
                if ($this->infosSemaine[$j]['PM'] != 0) {    // après-midi
                    $this->Cell(LARGEUR_COLONNE,12,"",1,0,"C", TRUE);   // congé
                } else {
                    $this->Cell(LARGEUR_COLONNE,12,"",1,0,"L");         // cours
                }
            }

            // affichage des cases pour retard et départ anticipé
            $this->SetXY(40,42+(16*$ligne));
            for ($j=0;$j<5;$j++){
                if ($this->infosSemaine[$j]['AM'] != 0) {    // matin
                    $this->Cell(LARGEUR_COLONNE,4,"",1,0,"C", TRUE);        // congé
                } else {
/*                    $this->Cell(LARGEUR_COLONNE,4,"R:        D:",1,0,"L");    // cours*/
                    $this->Cell(LARGEUR_COLONNE,4,"R:",1,0,"L");    // cours
                }
                
                if ($this->infosSemaine[$j]['PM'] != 0) {    // après-midi
                    $this->Cell(LARGEUR_COLONNE,4,"",1,0,"C", TRUE);        // congé
                } else {
/*                    $this->Cell(LARGEUR_COLONNE,4,"R:        D:",1,0,"L");    // cours*/
                    $this->Cell(LARGEUR_COLONNE,4,"R:",1,0,"L");    // cours
                }
            }

            // on passe à la ligne suivante
            $ligne++;
            $this->Ln();    
        }
        
        // Affichage de la ligne "Formateur"
        $this->SetXY(10,30+(16*$ligne));
        $this->SetFillColor(224,224,224);

        $this->Cell(30,12,"Formateur",1,0,"C", TRUE);

        for ($j=0;$j<5;$j++){
            $this->Cell(LARGEUR_COLONNE,12,"",1,0,"C", TRUE);
            $this->Cell(LARGEUR_COLONNE,12,"",1,0,"C", TRUE);
        }

    }

    public function banniere() {
        $this->Image("images/banniereCF2M.jpg",281,20,13,100);
    }
}

?>