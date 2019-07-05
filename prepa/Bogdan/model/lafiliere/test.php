<?php
require_once "lafiliere.php";

$p1 = new lafiliere(
        ["lafiliere_idfiliere"=>3,
        "idlafiliere"=>15,
        "lenom"=>"Graphiste",
        "lacronyme"=>"Caca",
        "lacouleur"=>"Brun",
        "lepicto"=>"img/crayon.jpg"
           ]
);
var_dump($p1);