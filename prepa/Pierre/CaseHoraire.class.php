<?php

include_once 'constants.php';

class CaseHoraire {
    private $dateCase;
    private $typeCase;

    public function __construct(DateTime $date, int $type) {
        $this->dateCase = $date;

        switch($type)
        {
        case 0 : $this->typeCase = CF2M_CASE_COURS; break;
        case 1 : $this->typeCase = CF2M_CASE_CONGE; break;
        case 2 : $this->typeCase = CF2M_CASE_FERIE; break;
        case 3 : $this->typeCase = CF2M_CASE_EXTRALEGAL; break;
        case 4 : $this->typeCase = CF2M_CASE_WEEKEND; break;
        case 5 : $this->typeCase = CF2M_CASE_INCONNU; break;
        default: $this->typeCase = CF2M_CASE_ERREUR;
        }
    }

    public function date(){
        return $this->dateCase;
    }

    public function type(){
        return $this->typeCase;
    }
}
?>
