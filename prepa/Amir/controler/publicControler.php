<?php
/**
 * public
 */

$menu = $ledroitM->creerMenu();

/**
 *
 */

if (isset($_GET['idledroit']) && ctype_digit($_GET['idledroit'])) {

//var_dump($idthefiliere);

    $idledroit = (int) $_GET['idledroit'];

    $detailLedroit = $ledroitM->selectionnerLedroitParId($idledroit);

    echo $twig->render("accueilLedroit.html.twig", ["lemenu" =>
        $menu, "detailLedroit" => $detailLedroit]);

} else {

    $ledroit = $ledroitM->selectionnerLedroitIndexPublic();

    echo $twig->render("accueilLedroit.html.twig", ["lemenu" => $menu, "detailLedroit" => $ledroit]);
}
