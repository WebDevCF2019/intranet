<?php 
require("Planning.class.php");
require("Signature.class.php");

$lePlanning = new Planning(123);    // on suppose que l'ID session vaut 123

// on extrait la liste de stagiaires qui correspond à cette session et on formate "nom|prénom"
$stagiairesWEB = array("Abakar|Oumar", "Bouvy|Dimitri", "El Madyouni|Tarek", "Lammens|Jillian", "Le Boulaire|Jean-Baptiste", "Marique|Geoffrey", "Palmisano|André", "Ripa|Stéphane", "Rusu|Bogdan-Ionut");
$stagiairesPAO = array("Pascal|Houette", "Albert|Geronnette", "Richard|Donneret", "Martin|Paicheur", "Amir|Ondelle", "Pierre|Drix", "Eros|Signol");
$stagiairesAMM = array("Michaël|Aifant", "Omar|Motte", "Olga|Zel", "Fabian|Tilop", "Dimitri|Nocéros", "Cathy|Popotam", "Vincent|Glier", "Enrico|Chondainde", "André|Risson", "Nestor|Anhoutan");

// A partir du planning complet de la session, on extrait la semaine à afficher
$laSemaine = $lePlanning->extraireCetteSemaine();

// on formate les données pour l'affichage de la feuille de signature
// 1er indice = les 5 jours avec : 0 pour lundi, 1 pour mardi,..., 4 pour vendredi
// 2ème indice = "date" pour la date du jour, "AM" pour le matin (cours, congé,...), "PM" pour l'après-midi (cours, congé,...)
$infosSemaine = array();
$indice=0;
foreach($laSemaine as $cle=>$valeur){
    $infosSemaine[$indice]["date"] = new DateTime($cle);
    $infosSemaine[$indice]["AM"] = $valeur["AM"]->type();
    $infosSemaine[$indice]["PM"] = $valeur["PM"]->type();
    $indice++;
    }


$pdf = new feuilleSignature($infosSemaine);
/*
$pdf->AddPage();
$pdf->picto("images/web.png");
$pdf->entete("WEB");
$pdf->listeStagiaires($stagiairesWEB);
$pdf->banniere();
$pdf->Output("I","WEB01072019.pdf");
*/

$pdf->AddPage();
$pdf->picto("images/pao.png");
$pdf->entete("PAO");
$pdf->listeStagiaires($stagiairesPAO);
$pdf->banniere();
$pdf->Output("I","PAO01072019.pdf");
/*
$pdf->AddPage();
$pdf->picto("images/amm.png");
$pdf->entete("AMM");
$pdf->listeStagiaires($stagiairesAMM);
$pdf->banniere();
$pdf->Output("I","AMM01072019.pdf");
*/
?>
