<?php

/*
 * 
 * bonne base, noms de méthodes à revoir, modifications à effectuer
 * 
 * 
 */

class ledroitManager
{

    private $db; //connexion MyPDO

    public function __construct(MyPDO $connect)
    {
        $this->db = $connect;
    }

/**
 *
 * Methode de la partie public
 *
 */

    //creation du menu
    public function creerMenu(): array
    {
        $sql = "SELECT idledroit,ladescription,lintitule FROM ledroit ORDER BY lintitule ASC;";
        $recup = $this->db->query($sql);

        if ($recup->rowCount() === 0) {
            return [];
        }
        return $recup->fetchAll(PDO::FETCH_ASSOC);
    }

//creation de l'affichage
    public function selectionnerLedroitIndexPublic(): array
    {

        $sql = "SELECT * FROM ledroit ORDER BY lintitule ASC;";
        $recup = $this->db->query($sql);

        if ($recup->rowCount() === 0) {
            return [];
        }
        return $recup->fetchAll(PDO::FETCH_ASSOC);
    }

    //recuperation d'une filiere par son ID
    public function selectionnerLedroitParId(int $idledroit): array
    {
        if (empty($idledroit)) {
            return [];

        }
        $sql = "SELECT * FROM ledroit WHERE idledroit = ?;";
        $recup = $this->db->prepare($sql);
        $recup->bindValue(1, $idledroit, PDO::PARAM_INT);
        $recup->execute();

        if ($recup->rowCount() === 0) {
            return [];
        }
        return $recup->fetch(PDO::FETCH_ASSOC);

    }

}
