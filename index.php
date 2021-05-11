<?php

    include("bdd.php");
    include("map.php");
    include("forge.php");
    include("entite.php");
    include("object.php");
    include("equipement.php");

    $idEntite = 1938;
    $idMap = 4330;
    $entite = new Entite($bdd);
    $entite->setEntiteById($idEntite);
    $map = new Map($bdd);
    $map->setMapById($idMap);
    $map->generateMap();
    if($map->isForge()){
        $forge = new forge($bdd);
        $forge->setForgeById($idMap);
        $entite->changeMap($forge);
        echo $forge->getNomForge().'<br>';
        $forge->vendre($entite, $idEntite);

    }else{
        echo 'Je suis une map '.$map->getNom();
    }

?>