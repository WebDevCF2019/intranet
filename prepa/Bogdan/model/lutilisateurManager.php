<?php
/**
 * Created by PhpStorm.
 * User: bogdan.rusu
 * Date: 01-07-19
 * Time: 15:13
 */

class lutilisateurManager
{

    private $db;

    public function __construct(MyPDO $connect)
    {
        $this->db = $connect;
    }

    // on essaie de se connecter
    public function afficheUsersComplete()
    {

        $sql = "SELECT lutilisateur.idlutilisateur,lutilisateur.lenom,lutilisateur.leprenom,lutilisateur.lemail,
linscription.debut,linscription.fin,
GROUP_CONCAT(lasession.lenom SEPARATOR '|||')AS nom_session,lasession.debut AS debut_session,lasession.fin AS fin_session,
GROUP_CONCAT(lafiliere.lenom SEPARATOR '|||') AS lenom_filiere,lafiliere.lepicto,
lerole.lintitule  AS lerole_Intitule,ledroit.lintitule AS droit
FROM lutilisateur
LEFT JOIN linscription ON lutilisateur.idlutilisateur=linscription.utilisateur_idutilisateur
LEFT JOIN lasession ON linscription.lasession_idsession=lasession.idlasession
LEFT JOIN lafiliere ON lasession.lafiliere_idfiliere=lafiliere.idlafiliere
LEFT JOIN lutilisateur_has_lerole ON lutilisateur.idlutilisateur=lutilisateur_has_lerole.lutilisateur_idutilisateur
LEFT JOIN lerole ON  lutilisateur_has_lerole.lerole_idlerole=lerole.idlerole
LEFT JOIN lerole_has_ledroit ON lerole.idlerole=lerole_has_ledroit.lerole_idlerole
LEFT JOIN ledroit ON  lerole_has_ledroit.ledroit_idledroit=ledroit.idledroit
GROUP BY lutilisateur.idlutilisateur 
ORDER BY lutilisateur.idlutilisateur;";

        $recup = $this->db->query($sql);

        if($recup->rowCount()===0){
            return [];
        }
        return $recup->fetchAll(PDO::FETCH_ASSOC);




} public function deleteStudentById(int $id):void{
    $sql="DELETE FROM lutilisateur WHERE idlutilisateur=?";
    $req = $this->db->prepare($sql);
    $req->bindValue(1,$id, PDO::PARAM_INT);
    $req->execute();



} public function createUser(lutilisateur $datas) {


    // vérification que les champs soient valides (pas vides)

    if(empty($datas->getLenomutilisateur())||empty($datas->getLenom()||empty($datas->getLeprenom()||empty($datas->getLemail())))){
        return false;
    }

    $sql = "INSERT INTO lutilisateur (lenomutilisateur,lenom,leprenom,lemail) VALUES(?,?,?,?);";

    $insert = $this->db->prepare($sql);


    $insert->bindValue(1,$datas->getLenomutilisateur(),PDO::PARAM_STR);
    $insert->bindValue(2,$datas->getLenom(),PDO::PARAM_STR);
    $insert->bindValue(3,$datas->getLeprenom(),PDO::PARAM_STR);
    $insert->bindValue(4,$datas->getLemail(),PDO::PARAM_STR);


    // gestion des erreurs avec try catch
    try {
        $insert->execute();
        return true;

    }catch(PDOException $e){
        echo $e->getCode();
        return false;

    }

}


}
